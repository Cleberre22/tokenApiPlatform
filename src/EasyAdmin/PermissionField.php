<?php

namespace App\EasyAdmin;

use Doctrine\DBAL\Types\ArrayType;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;

class PermissionField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null)
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            // this template is used in 'index' and 'detail' pages
            ->setTemplatePath('admin/field/permission.html.twig')
            // this is used in 'edit' and 'new' pages to edit the field contents
            // you can use your own form types too
            ->setFormType(TextType::class)
            ->addCssClass('field-text')
            ->setDefaultColumns('col-md-12 col-xxl-5');
    }
}