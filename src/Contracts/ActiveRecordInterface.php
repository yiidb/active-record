<?php

declare(strict_types=1);

namespace YiiDb\ActiveRecord\Contracts;

use ArrayAccess;
use YiiDb\ActiveRecord\ActiveQuery;
use YiiDb\ActiveRecord\ActiveRecordState;
use YiiDb\ActiveRecord\Attributes\TableName;

interface ActiveRecordInterface extends ArrayAccess//, Traversable
{
    public function __construct(ActiveRecordManagerInterface $arManager = null);

    public function getARManager(): ActiveRecordManagerInterface;

//    public function cloneRecord(): static;

    public static function find(ActiveRecordManagerInterface $arManager = null): ActiveQueryInterface;

    /**
     * @param array<string, mixed> $attributes
     */
    public static function create(array $attributes = [], ActiveRecordManagerInterface $arManager = null): static;

//    public function delete(): void;
//
//    public static function deleteAll(
//        ActiveRecordManagerInterface $arManager,
//        string|array|SqlStringInterface $conditions = '',
//        array $params = []
//    ): int;
//
//    public static function find(ActiveRecordManagerInterface $arManager): ActiveQueryInterface;
//
//    public static function findBySql(ActiveRecordManagerInterface $arManager, string $sql): ActiveQueryInterface;
//
//    public function getARManager(): ActiveRecordManagerInterface;
//
//    /**
//     * @return string[]
//     */
//    public static function getAttributes(): array;
//
//    /**
//     * @return ActiveRecordBehaviorInterface[]
//     */
//    public function getBehaviors(): array;
//
//    public function getFresh(): static;
//
//    public function getOriginalValue(string $attribute): mixed;
//
//    /**
//     * @param string[] $attributes
//     * @return array<string, mixed>
//     */
//    public function getOriginalValues(array $attributes = null): array;
//
//    /**
//     * @return string[]
//     */
//    public function getPrimaryKeys(): array;
//
//    /**
//     * @return string[]
//     */
//    public static function getSafeAttributes(): array;
//
//    public function getScenario(): string;
//
//    /**
//     * @return string[]
//     */
//    public function getScenarios(): array;
//
//    public static function getTableName(): string;
//
//    public function getValidateErrors(): ResultSet;

    public function getValue(string $attribute): mixed;

    /**
     * @param string[] $attributes
     * @return array<string, mixed>
     */
    public function getValues(array $attributes = null): array;

    public function hasAttribute(string $attribute): bool;

    /**
     * @param list<string>|null $attributes
     */
    public function insert(array $attributes = null): bool;

//    /**
//     * @param string|list<string> $attributes
//     */
//    public function isClean(string|array $attributes): bool;
//
//    /**
//     * @param string|list<string> $attributes
//     */
//    public function isDirty(string|array $attributes): bool;
//
//    public function isEquals(ActiveRecordInterface $record): bool;

    /**
     * @param string[]|null $attributes
     */
    public function loadDefaultValues(bool $skipIfSet = true, array $attributes = null): static;

//    /**
//     * @param array<string, mixed> $values
//     */
//    public function loadSafeValues(array $values): static;

    /**
     * @param array<string, mixed> $attributes
     */
    public static function make(array $attributes = [], ActiveRecordManagerInterface $arManager = null): static;

//    public function refresh(): bool;
//
//    public function removeBehavior(string $name): void;
//
//    /**
//     * @param string[]|null $attributes
//     */
//    public function replace(bool $runValidation = true, array $attributes = null): bool;
//
//    /**
//     * @param string[]|null $attributes
//     */
//    public function save(bool $runValidation = true, array $attributes = null): bool;
//
//    public function setBehavior(string $name, ActiveRecordBehaviorInterface $behavior): void;
//
//    public function setOriginalValue(string $name, mixed $value): void;
//
//    /**
//     * @param array<string, mixed> $values
//     */
//    public function setOriginalValues(array $values): static;
//
//    public function setScenario(string $name): static;

    public function setValue(string $attribute, mixed $value): void;

    /**
     * @param array<string, mixed> $values
     */
    public function setValues(array $values): static;

//    /**
//     * @param array<string, mixed> $attributes
//     */
//    public function update(bool $runValidation = true, array $attributes = null): int;
//
//    /**
//     * @param array<string, mixed> $attributes
//     */
//    public static function updateAll(
//        ActiveRecordManagerInterface $arManager,
//        array $attributes,
//        string|array|SqlStringInterface $conditions = '',
//        array $params = []
//    ): int;
//
//    /**
//     * @param array<string, int> $counters
//     */
//    public static function updateAllCounters(
//        ActiveRecordManagerInterface $arManager,
//        array $counters,
//        string|array|SqlStringInterface $conditions = '',
//        array $params = []
//    ): int;
//
//    /**
//     * @param string|list<string> $attributes
//     */
//    public function wasChanged(string|array $attributes): bool;

    public function getState(): ActiveRecordState;

    /**
     * @internal
     */
    public function setState(ActiveRecordState $state): static;

    public static function getTableName(): TableName;

    public static function getConnectionName(): ?string;

    /**
     * @return array<string, string>
     */
    public function getAttributes(): array;

    /**
     * @param array<string, mixed> $values
     * @return void
     */
    public function initFromRawValues(array $values): void;
}
