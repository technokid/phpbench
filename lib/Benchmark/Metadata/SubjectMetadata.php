<?php

/*
 * This file is part of the PHPBench package
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace PhpBench\Benchmark\Metadata;

/**
 * Metadata for benchmarkMetadata subjects.
 */
class SubjectMetadata
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array[]
     */
    private $parameterSets = [];

    /**
     * @var string[]
     */
    private $groups = [];

    /**
     * @var string[]
     */
    private $beforeMethods = [];

    /**
     * @var string[]
     */
    private $afterMethods = [];

    /**
     * @var string[]
     */
    private $paramProviders = [];

    /**
     * @var float|null
     */
    private $retryThreshold;

    /**
     * @var int[]
     */
    private $iterations = [1];

    /**
     * @var int[]
     */
    private $revs = [1];

    /**
     * @var int[]
     */
    private $warmup = [0];

    /**
     * @var bool
     */
    private $skip = false;

    /**
     * @var int
     */
    private $sleep = 0;

    /**
     * @var string|null
     */
    private $outputTimeUnit = null;

    /**
     * @var int|null
     */
    private $outputTimePrecision = null;

    /**
     * @var string|null
     */
    private $outputMode = null;

    /**
     * @var BenchmarkMetadata
     */
    private $benchmarkMetadata;

    /**
     * @var array<string>
     */
    private $assertions = [];

    /**
     * @var ExecutorMetadata|null
     */
    private $executorMetadata;

    /**
     * @var float|null
     */
    private $timeout = 0;

    /**
     */
    public function __construct(BenchmarkMetadata $benchmarkMetadata, string $name)
    {
        $this->name = $name;
        $this->benchmarkMetadata = $benchmarkMetadata;
    }

    /**
     * Return the method name of this subject.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the parameter sets for this subject.
     *
     * @param array[] $parameterSets
     */
    public function setParameterSets(array $parameterSets): void
    {
        $this->parameterSets = $parameterSets;
    }

    /**
     * Return the parameter sets for this subject.
     *
     * @return array[]
     */
    public function getParameterSets(): array
    {
        return $this->parameterSets;
    }

    /**
     * Return the benchmarkMetadata metadata for this subject.
     */
    public function getBenchmark(): BenchmarkMetadata
    {
        return $this->benchmarkMetadata;
    }

    public function getGroups(): array
    {
        return $this->groups;
    }

    public function inGroups(array $groups): bool
    {
        return (bool) count(array_intersect($this->groups, $groups));
    }

    public function setGroups(array $groups): void
    {
        $this->groups = $groups;
    }

    public function getBeforeMethods(): array
    {
        return $this->beforeMethods;
    }

    public function setBeforeMethods(array $beforeMethods): void
    {
        $this->beforeMethods = $beforeMethods;
    }

    public function getAfterMethods(): array
    {
        return $this->afterMethods;
    }

    public function setAfterMethods(array $afterMethods): void
    {
        $this->afterMethods = $afterMethods;
    }

    public function getParamProviders(): array
    {
        return $this->paramProviders;
    }

    public function setParamProviders(array $paramProviders): self
    {
        $this->paramProviders = $paramProviders;

        return $this;
    }

    public function getIterations(): array
    {
        return $this->iterations;
    }

    public function setIterations(array $iterations): void
    {
        $this->iterations = $iterations;
    }

    public function getRevs(): array
    {
        return $this->revs;
    }

    public function setRevs(array $revs): void
    {
        $this->revs = $revs;
    }

    public function getSkip(): bool
    {
        return $this->skip;
    }

    public function setSkip(bool $skip): void
    {
        $this->skip = $skip;
    }

    public function getSleep(): int
    {
        return $this->sleep;
    }

    public function setSleep(int $sleep): void
    {
        $this->sleep = $sleep;
    }

    public function getOutputTimeUnit(): ?string
    {
        return $this->outputTimeUnit;
    }

    public function setOutputTimeUnit(?string $outputTimeUnit): void
    {
        $this->outputTimeUnit = $outputTimeUnit;
    }

    public function getOutputTimePrecision(): ?int
    {
        return $this->outputTimePrecision;
    }

    public function setOutputTimePrecision(?int $outputTimePrecision): void
    {
        $this->outputTimePrecision = $outputTimePrecision;
    }

    public function getOutputMode(): ?string
    {
        return $this->outputMode;
    }

    public function setOutputMode(?string $outputMode): void
    {
        $this->outputMode = $outputMode;
    }

    public function getWarmup(): array
    {
        return $this->warmup;
    }

    public function setWarmup(array $warmup): void
    {
        $this->warmup = $warmup;
    }

    public function getRetryThreshold(): ?float
    {
        return $this->retryThreshold;
    }

    public function setRetryThreshold(?float $retryThreshold): void
    {
        $this->retryThreshold = $retryThreshold;
    }

    public function addAssertion(string $assertion): void
    {
        $this->assertions[] = $assertion;
    }

    /**
     * @param array<string> $assertions
     */
    public function setAssertions(array $assertions): void
    {
        $this->assertions = [];

        foreach ($assertions as $assertion) {
            $this->addAssertion($assertion);
        }
    }

    /**
     * @return array<string>
     */
    public function getAssertions(): array
    {
        return $this->assertions;
    }

    public function getExecutor(): ?ExecutorMetadata
    {
        return $this->executorMetadata;
    }

    public function setExecutor(ExecutorMetadata $serviceMetadata): void
    {
        $this->executorMetadata = $serviceMetadata;
    }

    public function getTimeout(): ?float
    {
        return $this->timeout;
    }

    public function setTimeout(?float $timeout): void
    {
        $this->timeout = $timeout;
    }
}
