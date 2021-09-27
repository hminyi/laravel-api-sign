<?php

namespace Zsirius\Signature\Services;

use Zsirius\Signature\Exceptions\SignException;

class Signature
{
    /**
     * 检查sign是否匹配
     *
     * @param  array  $params
     * @return bool
     */
    public function checkSign($params)
    {
        if (!array_key_exists('appid', $params)) {
            throw new SignException('should have appid');
        }

        if (!array_key_exists('sign', $params)) {
            throw new SignException('should have sign');
        }

        $now = time();

        $appid = $params['appid'];
        $timestamp = $params['timestamp'] ?? $now;
        // 密钥信息
        $info = $this->getConfig($appid);
        // 检查密钥状态
        if (!$info || !$info['status']) {
            throw new SignException('key failure');
        }
        // 检查时间
        $effect_time = $info['timestamp'] ?? 0;
        if (abs($now - $timestamp) > $effect_time) {
            throw new SignException('timestamp error');
        }
        // 检查签名
        $sign = $params['sign'] ?? ''; // 加密签名
        unset($params['sign']);

        if ($this->createSign($params) != strtoupper($sign)) {
            throw new SignException('sign error');
        }
    }

    /**
     * 创建签名
     *
     * @param  array    $params
     * @param  string   $token
     * @return string
     */
    protected function createSign($params)
    {
        $info = $this->getConfig($params['appid']);
        $app_secret = $info['app_secret'] ?? '';

        ksort($params);
        $sign_str = http_build_query($params);
        return strtoupper(md5(sha1($sign_str) . $app_secret));
    }

    /**
     * 获取appid对应的信息
     *
     * @param  int          $app_id
     * @return array|null
     */
    protected function getConfig($app_id)
    {
        $apps = config('signature.apps') ?? [];

        $info = [];
        foreach ($apps as $v) {
            if ($v['app_id'] == $app_id) {
                $info = $v;
                break;
            }
        }
        return $info;
    }
}
