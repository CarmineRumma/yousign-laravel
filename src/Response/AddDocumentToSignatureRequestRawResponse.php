<?php
namespace CarmineRumma\YousignLaravel\Response;
use CarmineRumma\YousignLaravel\Models\EmailNotification;
use CarmineRumma\YousignLaravel\Models\ReminderSettings;

class AddDocumentToSignatureRequestRawResponse
{
  public string $id;
  public string $filename;
  public string $nature;
  public string $content_type;
  public string $sha256;
  /**
   * @var boolean
   */
  public bool $is_protected;
  public bool $is_signed;
  public string $createdAt;
  /**
   * @var int
   */
  public int $total_pages;
  public bool $is_locked;
  public int $total_anchors;
  /**
   * @var Initials|null
   */
  public ?Initials $initials;



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
