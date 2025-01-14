<?php

namespace App\Controller\Admin;

use App\Entity\Partner;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class PartnerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Partner::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextEditorField::new('description'),
            TextField::new('logo'),
            UrlField::new('website'),
            AssociationField::new('categories')
            ->setLabel('Catégory')
            ->setFormTypeOptions([
                'by_reference' => true,
                'multiple' => false,  
            ])
            ->setRequired(true),
            CollectionField::new('interventions')->useEntryCrudForm(InterventionsCrudController::class)->allowDelete(),
            CollectionField::new('activities')->useEntryCrudForm(ActivitiesCrudController::class)->allowDelete()
        ];
    }
    
}
