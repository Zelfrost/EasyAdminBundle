<?php

/*
 * This file is part of the EasyAdminBundle.
 *
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JavierEguiluz\Bundle\EasyAdminBundle\Reflection;

/**
 * Introspects information about the properties of the given class.
 */
class ClassPropertyReflector
{
    /**
     * Returns the name of the getter for the class property or null if there is none.
     *
     * @param  string      $classNamespace
     * @param  string      $propertyName
     * @return string|null
     */
    public function getGetter($classNamespace, $propertyName)
    {
        $getterMethods = array(
            'get'.ucfirst($propertyName),
            'is'.ucfirst($propertyName),
            $propertyName,
            'has'.ucfirst($propertyName),
        );

        foreach ($getterMethods as $method) {
            if (method_exists($classNamespace, $method)) {
                return $method;
            }
        }
    }

    /**
     * Returns the name of the setter for the class property or null if there is none.
     *
     * @param  string      $classNamespace
     * @param  string      $propertyName
     * @return string|null
     */
    public function getSetter($classNamespace, $propertyName)
    {
        $setterMethods = array(
            'set'.ucfirst($propertyName),
            'setIs'.ucfirst($propertyName),
            $propertyName,
        );

        foreach ($setterMethods as $method) {
            if (method_exists($classNamespace, $method)) {
                return $method;
            }
        }
    }

    /**
     * Returns 'true' if the class property is public (it exists and its scope is 'public').
     *
     * @param  string $classNamespace
     * @param  string $propertyName
     * @return bool
     */
    public function isPublic($classNamespace, $propertyName)
    {
        if (!property_exists($classNamespace, $propertyName)) {
            return false;
        }

        $propertyMetadata = new \ReflectionProperty($classNamespace, $propertyName);
        if ($propertyMetadata->isPublic()) {
            return true;
        }
    }
}
