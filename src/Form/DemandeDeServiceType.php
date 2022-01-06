<?php

namespace App\Form;

use App\Entity\DemandeDeService;
use DateTime;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class DemandeDeServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, ['required' => true, 'trim' => true])
            ->add('prenom', TextType::class, ['required' => true, 'trim' => true])
            ->add('adresse', TextType::class, ['required' => true, 'trim' => true])
            ->add('telephone', TelType::class, ['required' => true, 'attr' => ['class' => 'telRegex']])
            ->add('courriel', EmailType::class, ['required' => true])
            ->add('description', TextareaType::class, ['required' => true, 'attr' => array('style' => 'height: 250px')])
            ->add('dateHeure', DateType::class, [ 'label' => ' ', 'data' => new \DateTime("America/New_York") , 'attr' => ['class' => 'date_heure']])
            ->add('statut', CheckboxType::class, ['required' => false, 'label' => ' ', 'attr' => ['class' => 'statut_box']])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DemandeDeService::class,
        ]);
    }
}
