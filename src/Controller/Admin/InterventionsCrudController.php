<?php

namespace App\Controller\Admin;

use App\Entity\Interventions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class InterventionsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Interventions::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextEditorField::new('description'),
            DateTimeField::new('date'),
            DateTimeField::new('enddate'),
            AssociationField::new('partner')
            ->setLabel('Partner')
            ->setFormTypeOptions([
                'by_reference' => true,
                'multiple' => false,  
            ])
            ->setRequired(true),
            IntegerField::new('places')
        ];
    }
    
}
