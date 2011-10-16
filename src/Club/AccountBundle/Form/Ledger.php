<?php

namespace Club\AccountBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;


class Ledger extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('account', 'entity', array(
      'class' => 'ClubAccountBundle:Account',
      'query_builder' => function(EntityRepository $er) {
        return $er->createQueryBuilder('a')
          ->where('a.account_type = :type')
          ->setParameter('type', 'expense');
      }
    ));
    $builder->add('value');
    $builder->add('note');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\AccountBundle\Entity\Ledger'
    );
  }

  public function getName()
  {
    return 'ledger';
  }
}
