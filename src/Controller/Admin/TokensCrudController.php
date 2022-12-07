<?php

namespace App\Controller\Admin;

use App\Entity\Tokens;
use App\EasyAdmin\PermissionField;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TokensCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tokens::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            yield IdField::new('id')->hideOnForm(),
            yield TextField::new('token')->hideOnForm(),
            yield TextField::new('keyName'),
            yield TextareaField::new('permission'),
            yield AssociationField::new('user', 'Utilisateur')->onlyOnIndex(),
            // yield PermissionField::new('permission')
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // if ($entityInstance instanceof Sport) return;

        $strTotal = 35;

        // Stockez toutes les lettres possibles dans une chaîne.
        $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $key = '';
        // Générez un index aléatoire de 0 à la longueur de la chaîne -1.
        for ($i = 0; $i < $strTotal; $i++) {
            $index = rand(0, strlen($str) - 1);
            $key .= $str[$index];
        }

        $entityInstance->setToken($key);
        $entityInstance->setUser($this->getUser());
        // $entityInstance->setCreatedAt(new \DateTimeImmutable);

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Tokens) return;

        // $entityInstance->setUpdatedAt(new \DateTimeImmutable);

        parent::updateEntity($entityManager, $entityInstance);
    }

}
