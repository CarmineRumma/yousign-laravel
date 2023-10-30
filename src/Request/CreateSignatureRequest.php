<?php

namespace CarmineRumma\YousignLaravel\Request;
use CarmineRumma\YousignLaravel\Models\EmailNotification;
use CarmineRumma\YousignLaravel\Models\ReminderSettings;

class CreateSignatureRequest
{
  public string $name;
  public string $deliveryMode;
  public bool $orderedSigners;
  public ReminderSettings $reminderSettings;
  public string $timezone;
  public string $emailCustomNote;
  public string $expirationDate;
  public string $templateId;
  public string $externalId;
  public string $customExperienceId;
  public string $workspaceId;
  public string $auditTrailLocale;
  public bool $signersAllowedToDecline;
  public EmailNotification $emailNotification;

  public function __construct(
    string $name,
    string $deliveryMode,
    bool $orderedSigners,
    ReminderSettings $reminderSettings,
    string $timezone,
    string $emailCustomNote,
    string $expirationDate,
    string $templateId,
    string $externalId,
    string $customExperienceId,
    string $workspaceId,
    string $auditTrailLocale,
    bool $signersAllowedToDecline,
    EmailNotification $emailNotification
  ) {
    $this->name = $name;
    $this->deliveryMode = $deliveryMode;
    $this->orderedSigners = $orderedSigners;
    $this->reminderSettings = $reminderSettings;
    $this->timezone = $timezone;
    $this->emailCustomNote = $emailCustomNote;
    $this->expirationDate = $expirationDate;
    $this->templateId = $templateId;
    $this->externalId = $externalId;
    $this->customExperienceId = $customExperienceId;
    $this->workspaceId = $workspaceId;
    $this->auditTrailLocale = $auditTrailLocale;
    $this->signersAllowedToDecline = $signersAllowedToDecline;
    $this->emailNotification = $emailNotification;
  }
}
