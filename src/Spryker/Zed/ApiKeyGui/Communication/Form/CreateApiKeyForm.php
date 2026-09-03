<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ApiKeyGui\Communication\Form;

use DateTime;
use Generated\Shared\Transfer\ApiKeyTransfer;
use Spryker\Zed\Gui\Communication\Form\Type\DatePickerType;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @method \Spryker\Zed\ApiKeyGui\Communication\ApiKeyGuiCommunicationFactory getFactory()
 * @method \Spryker\Zed\ApiKeyGui\ApiKeyGuiConfig getConfig()
 */
class CreateApiKeyForm extends AbstractType
{
    /**
     * @var string
     */
    protected const FIELD_NAME = 'name';

    /**
     * @var string
     */
    protected const LABEL_NAME = 'Name';

    /**
     * @var string
     */
    protected const FIELD_EXPIRATION = 'valid_to';

    /**
     * @var string
     */
    protected const LABEL_EXPIRATION = 'Valid to';

    /**
     * @var string
     */
    protected const VALIDITY_DATE_FORMAT = 'Y-m-d';

    /**
     * @var string
     */
    protected const MIN_DATE_EXPIRATION_INTERVAL = '+1 day';

    /**
     * @var string
     */
    protected const LEGACY_EXPIRATION_FIELD_CLASS = 'js-valid-to-date-picker safe-datetime';

    public function getBlockPrefix(): string
    {
        return 'api-key';
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'data_class' => ApiKeyTransfer::class,
        ]);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<mixed> $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addNameField($builder)
            ->addExpirationField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addNameField(FormBuilderInterface $builder)
    {
        $builder->add(
            static::FIELD_NAME,
            TextType::class,
            [
                'label' => static::LABEL_NAME,
                'required' => true,
            ],
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addExpirationField(FormBuilderInterface $builder)
    {
        $builder->add(
            static::FIELD_EXPIRATION,
            $this->getExpirationFieldType(),
            $this->getExpirationFieldOptions(),
        );

        $this->addDateTimeTransformer(static::FIELD_EXPIRATION, $builder);

        return $this;
    }

    protected function getExpirationFieldType(): string
    {
        if ($this->isGuiDatePickerTypeAvailable()) {
            return DatePickerType::class;
        }

        return DateType::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function getExpirationFieldOptions(): array
    {
        $options = [
            'label' => 'Valid To',
            'required' => false,
        ];

        if ($this->isGuiDatePickerTypeAvailable()) {
            return $options + [
                // An API key must stay valid for at least one full day. The picker only understands
                // `today` or a concrete date in the field's own format, not relative offsets, so the
                // bound is resolved to a date here.
                'min_date' => $this->createMinExpirationDate(),
            ];
        }

        return $options + [
            'widget' => 'single_text',
            'attr' => [
                'class' => static::LEGACY_EXPIRATION_FIELD_CLASS,
            ],
        ];
    }

    protected function isGuiDatePickerTypeAvailable(): bool
    {
        return class_exists(DatePickerType::class);
    }

    protected function createMinExpirationDate(): string
    {
        return (new DateTime(static::MIN_DATE_EXPIRATION_INTERVAL))->format(static::VALIDITY_DATE_FORMAT);
    }

    protected function addDateTimeTransformer(string $fieldName, FormBuilderInterface $builder): void
    {
        $builder
            ->get($fieldName)
            ->addModelTransformer(new CallbackTransformer(
                function ($dateAsString) {
                    if (!$dateAsString) {
                        return null;
                    }

                    return new DateTime($dateAsString);
                },
                function ($dateAsObject) {
                    if (!$dateAsObject) {
                        return null;
                    }

                    return $dateAsObject->format(static::VALIDITY_DATE_FORMAT);
                },
            ));
    }
}
