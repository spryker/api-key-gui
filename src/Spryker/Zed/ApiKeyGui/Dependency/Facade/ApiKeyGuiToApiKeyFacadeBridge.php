<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ApiKeyGui\Dependency\Facade;

use Generated\Shared\Transfer\ApiKeyCollectionDeleteCriteriaTransfer;
use Generated\Shared\Transfer\ApiKeyCollectionRequestTransfer;
use Generated\Shared\Transfer\ApiKeyCollectionResponseTransfer;
use Generated\Shared\Transfer\ApiKeyCollectionTransfer;
use Generated\Shared\Transfer\ApiKeyCriteriaTransfer;
use Spryker\Zed\ApiKey\Business\ApiKeyFacadeInterface;

class ApiKeyGuiToApiKeyFacadeBridge implements ApiKeyGuiToApiKeyFacadeInterface
{
    /**
     * @var \Spryker\Zed\ApiKey\Business\ApiKeyFacadeInterface
     */
    protected ApiKeyFacadeInterface $apiKeyFacade;

    /**
     * @param \Spryker\Zed\ApiKey\Business\ApiKeyFacadeInterface $apiKeyFacade
     */
    public function __construct($apiKeyFacade)
    {
        $this->apiKeyFacade = $apiKeyFacade;
    }

    public function getApiKeyCollection(
        ApiKeyCriteriaTransfer $apiKeyCriteriaTransfer
    ): ApiKeyCollectionTransfer {
        return $this->apiKeyFacade->getApiKeyCollection($apiKeyCriteriaTransfer);
    }

    public function createApiKeyCollection(
        ApiKeyCollectionRequestTransfer $apiKeyCollectionRequestTransfer
    ): ApiKeyCollectionResponseTransfer {
        return $this->apiKeyFacade->createApiKeyCollection($apiKeyCollectionRequestTransfer);
    }

    public function updateApiKeyCollection(
        ApiKeyCollectionRequestTransfer $apiKeyCollectionRequestTransfer
    ): ApiKeyCollectionResponseTransfer {
        return $this->apiKeyFacade->updateApiKeyCollection($apiKeyCollectionRequestTransfer);
    }

    public function deleteApiKeyCollection(
        ApiKeyCollectionDeleteCriteriaTransfer $apiKeyCollectionDeleteCriteriaTransfer
    ): ApiKeyCollectionResponseTransfer {
        return $this->apiKeyFacade->deleteApiKeyCollection($apiKeyCollectionDeleteCriteriaTransfer);
    }
}
