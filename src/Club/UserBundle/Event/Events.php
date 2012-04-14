<?php

namespace Club\UserBundle\Event;

final class Events
{
  const onPasswordReset = 'password.reset';
  const onUserNew = 'user.new';
  const onUserActivate = 'user.activate';
  const onMemberView = 'member.view';
  const onGroupEdit = 'group.edit';
}
