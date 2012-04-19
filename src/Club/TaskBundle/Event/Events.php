<?php

namespace Club\TaskBundle\Event;

final class Events
{
  const onGroupTask = 'group.task';
  const onLogTask = 'log.task';
  const onLoginAttemptTask = 'login_attempt.task';
  const onBanTask = 'ban.task';
  const onMailTask = 'mail.task';
  const onMessageTask = 'message.task';
  const onAutoRenewalTask = 'auto_renewal.task';
  const onTeamTask = 'team.task';
  const onTeamPenalty = 'team.penalty';
  const onTaskError = 'task.error';
  const onMatchTask = 'match.task';
  const onBookingCleanup = 'booking.cleanup';
}
