<?php

namespace PHPSTORM_META {

    registerArgumentsSet(
        'doctrineDbalParameterType',
        \Doctrine\DBAL\ParameterType::NULL,
        \Doctrine\DBAL\ParameterType::INTEGER,
        \Doctrine\DBAL\ParameterType::STRING,
        \Doctrine\DBAL\ParameterType::LARGE_OBJECT,
        \Doctrine\DBAL\ParameterType::BOOLEAN,
        \Doctrine\DBAL\ParameterType::BINARY,
        \Doctrine\DBAL\ParameterType::ASCII
    );

    registerArgumentsSet(
        'yiiDbalExpressionBuilderOperator',
        \YiiDb\ActiveRecord\DBAL\Expressions\ExpressionBuilder::EQ,
        \YiiDb\ActiveRecord\DBAL\Expressions\ExpressionBuilder::NEQ,
        \YiiDb\ActiveRecord\DBAL\Expressions\ExpressionBuilder::LT,
        \YiiDb\ActiveRecord\DBAL\Expressions\ExpressionBuilder::LTE,
        \YiiDb\ActiveRecord\DBAL\Expressions\ExpressionBuilder::GT,
        \YiiDb\ActiveRecord\DBAL\Expressions\ExpressionBuilder::GTE
    );

    expectedArguments(
        \YiiDb\ActiveRecord\DBAL\Parameter::__construct(),
        1,
        argumentsSet('doctrineDbalParameterType')
    );

    expectedArguments(
        \YiiDb\ActiveRecord\DBAL\Expressions\ExpressionBuilder::createParameter(),
        1,
        argumentsSet('doctrineDbalParameterType')
    );

    expectedArguments(
        \YiiDb\ActiveRecord\DBAL\Expressions\ExpressionBuilder::comparison(),
        1,
        argumentsSet('yiiDbalExpressionBuilderOperator')
    );

    expectedArguments(
        \YiiDb\ActiveRecord\DBAL\Expressions\ExpressionBuilder::comparison(),
        3,
        argumentsSet('doctrineDbalParameterType')
    );

    expectedArguments(
        \YiiDb\ActiveRecord\DBAL\Expressions\ExpressionBuilder::comparisonColumns(),
        1,
        argumentsSet('yiiDbalExpressionBuilderOperator')
    );

    expectedArguments(
        \YiiDb\ActiveRecord\DBAL\Expressions\ExpressionBuilder::comparisonSqlFragment(),
        1,
        argumentsSet('yiiDbalExpressionBuilderOperator')
    );

    expectedArguments(
        \YiiDb\ActiveRecord\DBAL\Expressions\ExpressionBuilder::comparisonSqlFragment(),
        3,
        argumentsSet('doctrineDbalParameterType')
    );

    expectedArguments(
        \YiiDb\ActiveRecord\DBAL\Expressions\ExpressionBuilder::eq(),
        2,
        argumentsSet('doctrineDbalParameterType')
    );

    expectedArguments(
        \YiiDb\ActiveRecord\DBAL\Expressions\ExpressionBuilder::neq(),
        2,
        argumentsSet('doctrineDbalParameterType')
    );

    expectedArguments(
        \YiiDb\ActiveRecord\DBAL\Expressions\ExpressionBuilder::lt(),
        2,
        argumentsSet('doctrineDbalParameterType')
    );

    expectedArguments(
        \YiiDb\ActiveRecord\DBAL\Expressions\ExpressionBuilder::lte(),
        2,
        argumentsSet('doctrineDbalParameterType')
    );

    expectedArguments(
        \YiiDb\ActiveRecord\DBAL\Expressions\ExpressionBuilder::gt(),
        2,
        argumentsSet('doctrineDbalParameterType')
    );

    expectedArguments(
        \YiiDb\ActiveRecord\DBAL\Expressions\ExpressionBuilder::gte(),
        2,
        argumentsSet('doctrineDbalParameterType')
    );
}
