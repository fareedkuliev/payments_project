<?php
namespace App\Service;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenService
{
    public function createToken(...$params)
    {
        $privateKey = "nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDecLYmj8nDuHKB\nOhnXdSJ9M4+weoTHeax3nB9cUqNoqjKKfB4d71C+WEldtMf61whYQ3YM7taXfWU1\ndalqLi6nvMyJPRUjuf3hvCS+YnbvnoRYOvu6a+8KtIogWJFIq4g/DKxiKbY0A/aJ\noddU+5njNl20+mEw6+UaRwacX3/dbhYRB7WskMjQCaGKk9XN+eHAaIAPikyhVoIv\nEOe0x6l5RRSCrJtYM0C7/HDGoSbhViBGoHD/od1RSMzJ+t5lQhFaiMQblx8kUqfo\nSJ0c8v6s2sMTvYcmrw9t8RKCPo2+RSNLrJXPYe7oAevbrKNWbC7Br3CbFULCJFTK\nREUC/btfAgMBAAECggEAHVlTvzzDi05f1UscM8Bhv5E5CTjxIfyc099GiADjTKEA\nMCN2Oc7koWi2rWV36VHL6RFllwlASRajbu1KYBcd0sXnWsgzbNZSeCFB29jUBoOs\nxJNruUoabRgrDV+CM8tmG6OJbx4/yxcmxTwUVEMqJ795l7Jddn35aYErjyBOl6F6\nzQBkzxo5a7mt6Gd6M9xMeBS3TycGFQkAz1tGwEJc+In0AfVxSR4xd+dHoCfKOu46\neZ7Z2GaaMOxxdPTh/H4CA+XGHDhUBk6ZR1BSAS4sbHa2968TcmTOcTS/A3zbKjS6\nJJhPe7zMLh2GL8RkZYuNp3PrdAuYE0iZarfJn89BgQKBgQD0KThTGIoc0JTjB66i\neNChee5mtKEjnGRxBacGXTFMiNY/xLqvpfQUhYQvSCJu9TkS8KPp3HXodtHhPYQY\nKd+TZPrmSkzeT55Rs9Ff/kWm4zuc2cDipFxb184Y8SrQV7lnj/xO0JmXcfdiat1k\n3hrq3KczK16v6OUn167LXOiSwQKBgQDpOd8Fv/W40ZB3RxScXQ0Ohs311Q3GhQRe\nL1ydHWisurNw01YofVtemUVv1/sFaJd1nIbrpB7iAjTFFEFHVMHHDu600Fv60wcv\ng1FGXx+Svj+/RqCQsGHGkDW9BCh5XW40x/Yk8oR86jFe2+9rpmo3hPHj+BrfvPQT\nLmksze92HwKBgQCgL+8BLYdncj1MWfzsIWGXn3yWq4lQ6MlJEZFMbpXqhZgzDCoD\nFVj2ocZgku3saDyCvZh81SQSWOpH4WkpxUcm18h4kGSwMgJHzjbeyN7/p/Oza3XN\n/FGP/Bz+ZjNVr0g3ttKtDtTF9IJ+cmhARivYzN1xh9G+jYjSxAGs8I6xwQKBgQDj\nHLrEM6EKH/DJZkt41NghHD62NImclu2g9gf+66OCCLEynmoZNbFjFmhauHy2UJql\nKg7sqr50IefXPpku6CdnO3BSXVAkmZk2uG7N01XApUkYb6NuIoSkQsxByynKvaPS\n/CIC6rL/nWMEV7H3J2/prqmK8JDi7XLUtu4udj/IywKBgD1j8fE7MixYa0nLdt8r\nT9fPzLKIBKAb3G3m21e9JLeyKnnHBbhBLs3utgurd1p6QFhIekSvNLTPkzBTWsw9\n8x1+0DpFOVht/XgchkxYVL8npvMMNykowHvir3mZ5gOSE7EBIb6S5dwDc8JH1XFU\n5zWgoWHX4z7NzfQr+Q63UFcx";

        $now = time();
        $role = ((isset($params['data']['role'])) ? $params['data']['role'] : null);
        $aud = ((isset($params[0]['email'])) ? $params[0]['email'] : $params[0]);
        $payload = [
            'iss' => 'faradei@gmail.com',
            'iat' => $now,
            'exp' => $now + 3600,
            'aud' => $aud,
            'role' => $role,
            'data' => $params
        ];

        return JWT::encode($payload, $privateKey, 'HS512');

    }

    public function decodeToken($token)
    {
        $privateKey = "nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDecLYmj8nDuHKB\nOhnXdSJ9M4+weoTHeax3nB9cUqNoqjKKfB4d71C+WEldtMf61whYQ3YM7taXfWU1\ndalqLi6nvMyJPRUjuf3hvCS+YnbvnoRYOvu6a+8KtIogWJFIq4g/DKxiKbY0A/aJ\noddU+5njNl20+mEw6+UaRwacX3/dbhYRB7WskMjQCaGKk9XN+eHAaIAPikyhVoIv\nEOe0x6l5RRSCrJtYM0C7/HDGoSbhViBGoHD/od1RSMzJ+t5lQhFaiMQblx8kUqfo\nSJ0c8v6s2sMTvYcmrw9t8RKCPo2+RSNLrJXPYe7oAevbrKNWbC7Br3CbFULCJFTK\nREUC/btfAgMBAAECggEAHVlTvzzDi05f1UscM8Bhv5E5CTjxIfyc099GiADjTKEA\nMCN2Oc7koWi2rWV36VHL6RFllwlASRajbu1KYBcd0sXnWsgzbNZSeCFB29jUBoOs\nxJNruUoabRgrDV+CM8tmG6OJbx4/yxcmxTwUVEMqJ795l7Jddn35aYErjyBOl6F6\nzQBkzxo5a7mt6Gd6M9xMeBS3TycGFQkAz1tGwEJc+In0AfVxSR4xd+dHoCfKOu46\neZ7Z2GaaMOxxdPTh/H4CA+XGHDhUBk6ZR1BSAS4sbHa2968TcmTOcTS/A3zbKjS6\nJJhPe7zMLh2GL8RkZYuNp3PrdAuYE0iZarfJn89BgQKBgQD0KThTGIoc0JTjB66i\neNChee5mtKEjnGRxBacGXTFMiNY/xLqvpfQUhYQvSCJu9TkS8KPp3HXodtHhPYQY\nKd+TZPrmSkzeT55Rs9Ff/kWm4zuc2cDipFxb184Y8SrQV7lnj/xO0JmXcfdiat1k\n3hrq3KczK16v6OUn167LXOiSwQKBgQDpOd8Fv/W40ZB3RxScXQ0Ohs311Q3GhQRe\nL1ydHWisurNw01YofVtemUVv1/sFaJd1nIbrpB7iAjTFFEFHVMHHDu600Fv60wcv\ng1FGXx+Svj+/RqCQsGHGkDW9BCh5XW40x/Yk8oR86jFe2+9rpmo3hPHj+BrfvPQT\nLmksze92HwKBgQCgL+8BLYdncj1MWfzsIWGXn3yWq4lQ6MlJEZFMbpXqhZgzDCoD\nFVj2ocZgku3saDyCvZh81SQSWOpH4WkpxUcm18h4kGSwMgJHzjbeyN7/p/Oza3XN\n/FGP/Bz+ZjNVr0g3ttKtDtTF9IJ+cmhARivYzN1xh9G+jYjSxAGs8I6xwQKBgQDj\nHLrEM6EKH/DJZkt41NghHD62NImclu2g9gf+66OCCLEynmoZNbFjFmhauHy2UJql\nKg7sqr50IefXPpku6CdnO3BSXVAkmZk2uG7N01XApUkYb6NuIoSkQsxByynKvaPS\n/CIC6rL/nWMEV7H3J2/prqmK8JDi7XLUtu4udj/IywKBgD1j8fE7MixYa0nLdt8r\nT9fPzLKIBKAb3G3m21e9JLeyKnnHBbhBLs3utgurd1p6QFhIekSvNLTPkzBTWsw9\n8x1+0DpFOVht/XgchkxYVL8npvMMNykowHvir3mZ5gOSE7EBIb6S5dwDc8JH1XFU\n5zWgoWHX4z7NzfQr+Q63UFcx";
        return JWT::decode($token, new Key($privateKey, 'HS512'));
    }

}