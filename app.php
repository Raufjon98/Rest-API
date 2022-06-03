<?php
use OpenApi\Annotations as OA;
/**
 * @OA\Info(title="API notebook", version="1.0.0")
 */

/**
 * @OA\Get (
 * path="/records",
 * summary="Возвращает наиболее точный объект результата поиска",
 * description="Искать объект, если найден, вернуть его!",
 * @OA\RequestBody (
 * description="Объект поиска на стороне клиента",
 * required=true,
 * @OA\MediaType(
 * mediaType="application/json",
 * @OA\Schema(ref="#/components/schemas/SearchObject")
 * )
 * ),
 * @OA\Response(
 * response=200,
 * description="Успех",
 * @OA\Schema(ref="   #/components/schemas/SearchResultObject)
 * ),
 * @OA\Response(
 * response=404,
 * description="Не удалось найти ресурс"
 * )
 * )
 */
?>