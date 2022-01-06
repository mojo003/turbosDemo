<?php

namespace App\Form;

use App\Entity\ArchiveService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArchiveServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('adresse')
            ->add('telephone')
            ->add('courriel')
            ->add('description')
            ->add('dateHeure', DateType::class, [ 'label' => ' ', 'data' => new \DateTime("America/New_York") , 'attr' => ['class' => 'date_heure']])
            ->add('statut', CheckboxType::class, ['required' => false, 'label' => ' ', 'attr' => ['class' => 'statut_box']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArchiveService::class,
        ]);
    }
}
