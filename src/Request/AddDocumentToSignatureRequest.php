<?php

namespace CarmineRumma\YousignLaravel\Request;
use CarmineRumma\YousignLaravel\Models\EmailNotification;
use CarmineRumma\YousignLaravel\Models\ReminderSettings;

class AddDocumentToSignatureRequest
{
  public string $signatureRequestId;
  public string $file;

}
