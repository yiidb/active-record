<?php

declare(strict_types=1);

namespace YiiDb\ActiveRecord\Contracts;

// TODO: Рассмотреть возможность реализовать все методы перечисленные на этой странице:
// https://laravel.com/docs/8.x/eloquent-collections#method-contains

use const SORT_ASC;
use const SORT_DESC;

interface ActiveQueryInterface
{
    public const SORT_ASC = SORT_ASC;
    public const SORT_DESC = SORT_DESC;

//    /**
//     * @param array<string, self::SORT_ASC|self::SORT_DESC> $columns
//     * @return $this
//     */
//    public function addOrderBy(array $columns): static;
//
//    /**
//     * @param string|array<string, string|SqlStringInterface> $columns
//     */
//    public function addSelect(string|array $columns): static;
//
//    public function andHaving(string|array|SqlStringInterface $conditions): static;
//
//    public function andWhere(string|array|SqlStringInterface $conditions): static;
//
//    public function avg(string $column): int|float;
//
//    public function count(): mixed;
//
//    public function deleteAll(): int;
//
//    public function distinct(): static;
//
//    public function exists(): bool;
//
//    /**
//     * @return ActiveCollectionInterface<ActiveRecordInterface>
//     */
//    public function get(): ActiveCollectionInterface;
//
//    /**
//     * @return ActiveRecordInterface[]
//     */
//    public function getAllAsArray(): array;
//
//    /**
//     * @return iterable<ActiveRecordInterface>
//     */
//    public function getCursor(): iterable;
//
    public function getFirst(): ?ActiveRecordInterface;

    public function withAlias(string $alias = null): static;
//
//    /**
//     * @param array<string, mixed> $attributes
//     */
//    public function getFirstOrCreate(array $attributes = [], callable $handler = null): ActiveRecordInterface;
//
//    public function getFirstOrFail(): ActiveRecordInterface;
//
//    /**
//     * @param array<string, mixed> $attributes
//     */
//    public function getFirstOrMake(array $attributes = [], callable $handler = null): ActiveRecordInterface;
//
//    /**
//     * @return list<string>
//     */
//    public function getGroupBy(): array;
//
//    public function getHaving(): ?ConditionInterface;
//
//    /**
//     * @return array<string, self::SORT_ASC|self::SORT_DESC>
//     */
//    public function getOrderBy(): array;
//
//    /**
//     * @return list<string>
//     */
//    public function getSelect(): array;
//
//    public function getWhere(): ?ConditionInterface;
//
//    /**
//     * @param string|list<string> $columns
//     */
//    public function groupBy(string|array $columns): static;
//
//    public function having(string|array|ConditionInterface|SqlStringInterface $conditions): static;
//
//    public function max(string $column): mixed;
//
//    public function min(string $column): mixed;
//
//    /**
//     * @param array<string, self::SORT_ASC|self::SORT_DESC> $columns
//     * @return $this
//     */
//    public function orderBy(array $columns): static;
//
//    /**
//     * @param string|list<string> $columns
//     */
//    public function orderByAsc(string|array $columns): static;
//
//    /**
//     * @param string|list<string> $columns
//     */
//    public function orderByDesc(string|array $columns): static;
//
//    public function orderByRaw(string $rawString): static;
//
//    public function orHaving(string|array|SqlStringInterface $conditions): static;
//
//    public function orWhere(string|array|SqlStringInterface $conditions): static;
//
//    /**
//     * @param string|array<string, string|SqlStringInterface> $columns
//     */
//    public function select(string|array $columns): static;
//
//    public function sum(string $column): int|float;
//
//    /**
//     * @param array<string, mixed> $attributes
//     */
//    public function updateAll(array $attributes): int;
//
//    /**
//     * @param array<string, int> $counters
//     */
//    public function updateAllCounters(array $counters): int;
//
//    public function where(string|array|SqlStringInterface $conditions): static;
}
