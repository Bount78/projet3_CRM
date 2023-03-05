<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


class EventType extends AbstractType
{
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setMethod('POST') // ajout de cette ligne pour changer la méthode de GET à POST
            ->add('name', null, [
                'label' => 'Nom de l\'événement',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Entrez le nom de l\'événement'
                ]
            ])
            ->add('dateStart', DateTimeType::class, [
                'label' => 'Date et heure de début',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('dateEnd', DateTimeType::class, [
                'label' => 'Date et heure de fin',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter',
                'attr' => [
                    'class' => 'btn btn-primary',
                    'data-calendar-action' => 'add-event',
                    'data-route' => $this->router->generate('app_event_add')
                ]
            ]);
    }
}
