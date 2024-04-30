<?php

use Mth\Common\Config\Facades\Config;
use Mth\Common\Config\Services\ConfigService;
use Mth\Common\Config\Dto\Config as ConfigDTO;

beforeEach(function () {
    $this->configService = Mockery::mock(ConfigService::class);
    $this->app->instance(ConfigService::class, $this->configService);
});

it('checks if the environment is production', function () {
    $this->configService->shouldReceive('config')
                        ->with('app.env')
                        ->andReturn(
                            (new ConfigDTO)
                                ->setValue('production')
                        );

    expect(Config::isProduction())->toBeTrue()
                                  ->and(Config::isLocal())->toBeFalse()
                                  ->and(Config::isStaging())->toBeFalse()
                                  ->and(Config::isCI())->toBeFalse();
});

it('checks if the environment is local', function () {
    $this->configService->shouldReceive('config')
                        ->with('app.env')
                        ->andReturn((new ConfigDTO)->setValue('local'));

    expect(Config::isLocal())->toBeTrue()
                             ->and(Config::isProduction())->toBeFalse()
                             ->and(Config::isStaging())->toBeFalse()
                             ->and(Config::isCI())->toBeFalse();
});

it('retrieves a specific configuration value', function () {
    $configKey     = 'database.default';
    $expectedValue = 'pgsql';
    $this->configService->shouldReceive('config')
                        ->with($configKey)
                        ->andReturn((new ConfigDTO)->setValue($expectedValue));

    $config = Config::config($configKey);
    expect($config)->toBeInstanceOf(ConfigDTO::class)
                   ->and($config->getValue())->toEqual($expectedValue);
});

// Optionally, you can add more specific tests for 'staging' and 'ci' environments

afterEach(function () {
    Mockery::close();
});
