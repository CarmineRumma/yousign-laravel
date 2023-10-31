<?php
namespace CarmineRumma\YousignLaravel\Response;
use CarmineRumma\YousignLaravel\Models\EmailNotification;
use CarmineRumma\YousignLaravel\Models\ReminderSettings;

class CreateSignatureRequestRawResponse
{
  public EmailNotification $email_notification;
  public string $id;
  public string $source;
  public string $status;
  public string $name;
  public string $created_at;
  public ?string $email_custom_note;
  public bool $ordered_signers;
  public string $timezone;
  public ReminderSettings $reminder_settings;
  public string $expiration_date;
  public string $delivery_mode;
  public array $documents;
  public array $signers;
  public ?string $external_id;
  public ?string $branding_id;
  public ?string $custom_experience_id;
  public ?string $sender;
  public string $workspace_id;
  public string $audit_trail_locale;
  public bool $signers_allowed_to_decline;
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
