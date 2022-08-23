<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Equipement;
use App\Entity\Habitat;
use App\Entity\Media;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('file', FileType::class, [
            'label' => 'label.file',
            'required' => false
        ]);
        $builder->add('habitat', EntityType::class, [
            'class' => Habitat::class,
            'choice_label' => function (Habitat $habitat){
                return $habitat->getId();
            },
            'required' => false
        ]);
        $builder->add('user', EntityType::class, [
            'class' => User::class,
            'choice_label' => function (User $user){
                return $user->getId();
            },
            'required' => false
        ]);
        $builder->add('categorie', EntityType::class, [
            'class' => Categorie::class,
            'choice_label' => function (Categorie $cat){
                return $cat->getId();
            },
            'required' => false
        ]);
        $builder->add('equipement', EntityType::class, [
            'class' => Equipement::class,
            'choice_label' => function (Equipement $equi){
                return $equi->getId();
            },
            'required' => false
        ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
       $resolver->setDefaults([
        'data_class' => Media::class,
        'csrf_protection' => false

       ]);
    }
    public function getBlockPrefix()
    {
        return '';
    }
}