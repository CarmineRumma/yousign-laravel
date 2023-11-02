<?php
namespace CarmineRumma\YousignLaravel\Response;

use CarmineRumma\YousignLaravel\DTO\CustomText;
use CarmineRumma\YousignLaravel\DTO\Info;
use CarmineRumma\YousignLaravel\DTO\RedirectUrls;

class AddSignerToSignatureRequestRawResponse
{
  public string $id;
  public Info $info;
  public string $status;
  public $signature_link;
  public $signature_link_expiration_date;
  public string $signature_image_preview;
  public $fields;
  public string $signature_level;
  public string $signature_authentication_mode;
  public RedirectUrls $redirect_urls;
  public CustomText $custom_text;
  public $delivery_mode;

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
