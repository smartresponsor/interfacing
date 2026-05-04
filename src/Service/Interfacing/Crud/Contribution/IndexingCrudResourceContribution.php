<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud\Contribution;

use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceDescriptorContributionInterface;

final class IndexingCrudResourceContribution extends AbstractCrudResourceContribution implements CrudResourceDescriptorContributionInterface
{
    public function provide(): array
    {
        return [
            $this->canonicalResource('indexing.record', 'Indexing', 'Index record', 'index-record', 'Index record screens are needed for maintenance and search QA.'),
            $this->canonicalResource('indexing.index-job', 'Indexing', 'Index job', 'index-job', 'Index job CRUD frames expose rebuild/retry state in the shell.'),
            $this->canonicalResource('indexing.index-batch', 'Indexing', 'Index batch', 'index-batch', 'Batch-level screens support operator verification.'),
            $this->canonicalResource('indexing.searchable-document', 'Indexing', 'Searchable document', 'searchable-document', 'Searchable documents are visible even before full host integration.'),
            $this->canonicalResource('indexing.query-log', 'Indexing', 'Query log', 'query-log', 'Query logs provide a stable route-compatible inspection surface.'),
        ];
    }
}
