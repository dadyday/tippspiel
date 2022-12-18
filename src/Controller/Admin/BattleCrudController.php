<?php

namespace App\Controller\Admin;

use App\Entity;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field;

class BattleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Entity\Battle::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield Field\TextField::new('name');
        yield Field\AssociationField::new('team1')
            ->setFormTypeOptions([
                'by_reference' => false,
            ])
            #->autocomplete()
        ;
        yield Field\AssociationField::new('team2')
            ->setFormTypeOptions([
                'by_reference' => false,
            ])
            #->autocomplete()
        ;
    }
    
}
