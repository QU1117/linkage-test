<?php

namespace App\Jobs;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Models\CustomFieldsValues\MultitextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\TextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\MultitextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\MultitextCustomFieldValueModel;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;
use AmoCRM\Models\LeadModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Request;
use AmoCRM\Models\ContactModel;
use AmoCRM\Collections\ContactsCollection;
use App\Services\EventLogger;

class AmoAddLeadWithContactJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Request $request, protected AmoCRMApiClient $amoCRMApiClient)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $lead = new LeadModel();
        $lead->setName($this->request->json('name'))
            ->setPipelineId(env('AMOCRM_LEADS_PIPELINE_ID'))
            ->setStatusId(env('AMOCRM_LEADS_FIRST_CONTACT_ID'))
            ->setCustomFieldsValues(
                (new CustomFieldsValuesCollection())->add(
                    (new TextCustomFieldValuesModel())
                        ->setFieldId(env('AMOCRM_LEADS_APARTMENTS_ADDRESS_CUSTOM_FIELD_ID'))
                        ->setValues(
                            (new TextCustomFieldValueCollection())->add(
                                (new TextCustomFieldValueModel())->setValue(
                                    $this->request->json('apartment_address'))
                            )
                        )
                )
            );

        $contact = new ContactModel();
        $contact->setName($this->request->json('name'))
            ->setCustomFieldsValues(
                (new CustomFieldsValuesCollection())->add(
                    (new MultitextCustomFieldValuesModel())
                        ->setFieldCode('PHONE')
                        ->setValues(
                            (new MultitextCustomFieldValueCollection())->add(
                                (new MultitextCustomFieldValueModel())->setValue(
                                    $this->request->json('phone')
                                )
                            )
                        )
                )
            );

        $lead->setContacts((new ContactsCollection())->add($contact));

        try {
            $this->amoCRMApiClient->leads()->addOne($lead);
            $this->amoCRMApiClient->contacts()->addOne($contact);
        } catch (AmoCRMMissedTokenException|AmoCRMoAuthApiException|AmoCRMApiException $e) {
            (new EventLogger())::log('Exception', 'AmoCRM API Exception: ', data: $e->getMessage());
        }
    }
}
