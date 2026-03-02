<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ApiKeyGui\Communication;

use Orm\Zed\ApiKey\Persistence\SpyApiKeyQuery;
use Spryker\Zed\ApiKeyGui\ApiKeyGuiDependencyProvider;
use Spryker\Zed\ApiKeyGui\Communication\Form\CreateApiKeyForm;
use Spryker\Zed\ApiKeyGui\Communication\Form\DataProvider\EditApiKeyFormDataProvider;
use Spryker\Zed\ApiKeyGui\Communication\Form\DeleteApiKeyForm;
use Spryker\Zed\ApiKeyGui\Communication\Form\EditApiKeyForm;
use Spryker\Zed\ApiKeyGui\Communication\Generator\ApiKeyGenerator;
use Spryker\Zed\ApiKeyGui\Communication\Generator\ApiKeyGeneratorInterface;
use Spryker\Zed\ApiKeyGui\Communication\Table\ApiKeyTable;
use Spryker\Zed\ApiKeyGui\Dependency\Facade\ApiKeyGuiToApiKeyFacadeInterface;
use Spryker\Zed\ApiKeyGui\Dependency\Service\ApiKeyGuiToUtilTextServiceInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Symfony\Component\Form\FormInterface;

/**
 * @method \Spryker\Zed\ApiKeyGui\ApiKeyGuiConfig getConfig()
 */
class ApiKeyGuiCommunicationFactory extends AbstractCommunicationFactory
{
    public function createApiKeyTable(): ApiKeyTable
    {
        return new ApiKeyTable(
            $this->getApiKeyPropelQuery(),
        );
    }

    public function createEditApiKeyFormDataProvider(): EditApiKeyFormDataProvider
    {
        return new EditApiKeyFormDataProvider(
            $this->getApiKeyFacade(),
        );
    }

    public function getCreateApiKeyForm(): FormInterface
    {
        return $this->getFormFactory()->create(CreateApiKeyForm::class);
    }

    /**
     * @param array<mixed> $apiKeyData
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getEditApiKeyForm(array $apiKeyData): FormInterface
    {
        return $this->getFormFactory()->create(EditApiKeyForm::class, $apiKeyData);
    }

    public function createDeleteApiKeyForm(): FormInterface
    {
        return $this->getFormFactory()->create(DeleteApiKeyForm::class);
    }

    public function createApiKeyGenerator(): ApiKeyGeneratorInterface
    {
        return new ApiKeyGenerator(
            $this->getUtilTextService(),
            $this->getConfig(),
        );
    }

    public function getApiKeyPropelQuery(): SpyApiKeyQuery
    {
        return $this->getProvidedDependency(ApiKeyGuiDependencyProvider::PROPEL_QUERY_API_KEY);
    }

    public function getApiKeyFacade(): ApiKeyGuiToApiKeyFacadeInterface
    {
        return $this->getProvidedDependency(ApiKeyGuiDependencyProvider::FACADE_API_KEY);
    }

    public function getUtilTextService(): ApiKeyGuiToUtilTextServiceInterface
    {
        return $this->getProvidedDependency(ApiKeyGuiDependencyProvider::SERVICE_UTIL_TEXT);
    }
}
