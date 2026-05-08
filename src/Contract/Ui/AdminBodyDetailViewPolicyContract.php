<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Detail/show view policy for admin body workbench screens.
 *
 * Read-only resource screens must not drift into bespoke dashboard layouts.
 * The canonical provider mapping is Ant Design ProComponents PageContainer,
 * Descriptions, ProCard, Space, and action controls for view/edit/delete
 * affordances while Twig does not render the final detail region.
 */
final readonly class AdminBodyDetailViewPolicyContract
{
    public const KEY_DETAIL_VIEW_POLICY = 'detailViewPolicy';

    public const CONTRACT_NAME = 'admin-body-detail-view-policy';
    public const VERSION = '1.0';

    public const MODE_SHOW = 'show';
    public const MODE_READ_ONLY = 'read-only';

    public const SECTION_GENERAL = 'general';
    public const SECTION_METADATA = 'metadata';
    public const SECTION_RELATIONS = 'relations';

    public const ACTION_BACK = 'back-to-list';
    public const ACTION_EDIT = 'edit';
    public const ACTION_DELETE = 'delete';

    public const DELETE_CONFIRMATION = 'confirmation-required';

    public const PROVIDER_TARGET_PAGE = 'PageContainer';
    public const PROVIDER_TARGET_DESCRIPTIONS = 'Descriptions';
    public const PROVIDER_TARGET_META_CARD = 'ProCard.metadata';
    public const PROVIDER_TARGET_RELATION_CARD = 'ProCard.relations';
    public const PROVIDER_TARGET_ACTIONS = 'PageContainer.extra';
    public const PROVIDER_TARGET_DELETE_CONFIRM = 'Modal.confirm';

    /** @return list<string> */
    public static function requiredDetailViewPolicyKeys(): array
    {
        return [
            'name',
            'version',
            'mode',
            'layout',
            'sections',
            'actions',
            'destructiveActions',
            'providerTargets',
        ];
    }

    /** @return list<string> */
    public static function canonicalSections(): array
    {
        return [
            self::SECTION_GENERAL,
            self::SECTION_METADATA,
            self::SECTION_RELATIONS,
        ];
    }

    /** @return list<string> */
    public static function canonicalActions(): array
    {
        return [
            self::ACTION_BACK,
            self::ACTION_EDIT,
            self::ACTION_DELETE,
        ];
    }
}
