<?php

namespace Club\TaskBundle\Event;

final class Events
{
  const onGroupTask = 'group.task';
  const onLogTask = 'log.task';
  const onLoginAttemptTask = 'login_attempt.task';
  const onBanTask = 'ban.task';
  const onAutoRenewalTask = 'auto_renewal.task';
}
