<?php
namespace CarmineRumma\YousignLaravel\Response;
use CarmineRumma\YousignLaravel\Models\EmailNotification;
use CarmineRumma\YousignLaravel\Models\ReminderSettings;

class CreateSignatureRequestRawResponse
{
  public EmailNotification $emailNotification;
  public string $id;
  public string $source;
  public string $status;
  public string $name;
  public string $createdAt;
  public ?string $emailCustomNote;
  public bool $orderedSigners;
  public string $timezone;
  public ReminderSettings $reminderSettings;
  public string $expirationDate;
  public string $deliveryMode;
  public array $documents;
  public array $signers;
  public string $externalId;
  public ?string $brandingId;
  public ?string $customExperienceId;
  public ?string $sender;
  public string $workspaceId;
  public string $auditTrailLocale;
  public bool $signersAllowedToDecline;

  public function addDocument() {

  }

  /*
  public function __construct(
    EmailNotification $emailNotification,
    string $id,
    string $source,
    string $status,
    string $name,
    string $createdAt,
    ?string $emailCustomNote,
    bool $orderedSigners,
    string $timezone,
    ReminderSettings $reminderSettings,
    string $expirationDate,
    string $deliveryMode,
    array $documents,
    array $signers,
    string $externalId,
    ?string $brandingId,
    ?string $customExperienceId,
    ?string $sender,
    string $workspaceId,
    string $auditTrailLocale,
    bool $signersAllowedToDecline
  ) {
    $this->emailNotification = $emailNotification;
    $this->id = $id;
    $this->source = $source;
    $this->status = $status;
    $this->name = $name;
    $this->createdAt = $createdAt;
    $this->emailCustomNote = $emailCustomNote;
    $this->orderedSigners = $orderedSigners;
    $this->timezone = $timezone;
    $this->reminderSettings = $reminderSettings;
    $this->expirationDate = $expirationDate;
    $this->deliveryMode = $deliveryMode;
    $this->documents = $documents;
    $this->signers = $signers;
    $this->externalId = $externalId;
    $this->brandingId = $brandingId;
    $this->customExperienceId = $customExperienceId;
    $this->sender = $sender;
    $this->workspaceId = $workspaceId;
    $this->auditTrailLocale = $auditTrailLocale;
    $this->signersAllowedToDecline = $signersAllowedToDecline;
  }
  */
}
