<?php
return [
        //应用ID,您的APPID。
        'app_id' => "2016092500595631",

        //商户私钥，您的原始格式RSA私钥
        'merchant_private_key' => "MIIEowIBAAKCAQEA9vnM/Gumekr88neFU2w/WbxBIV5Ee3Pi3FsEmVwxnhw39mlczNPydqos1xv13NQPQUKabV2oTuvVtf0g0ZHrkaCMuIpUuW8GMvDwr0Pel3ZJ+z+EtCl7ML+iq46lzlT0hwm2SefB8AgaY1IjZs4oa6AAztHcdT3xBZs2pWrpRA54fPrjK/TT6bLfyQ9fAWm7ePfLOsQjvS+oIVaiDpeJCNJti0jTzD0CW/HhjtTdr8mxl2lymAxjoIJepmvod7WYptlkTOmfrr0An8AzhBSttzQg1RGFEUbLfS9iOW+XOKYyh0CGxG58Hxj29P0cFrR7EcGby6yQmLApuIK1gqe/5wIDAQABAoIBABomStDzKPZL2Epn40L49CAxMYgx7fhQRdXlATCntU0zWa2KbFv3mPV9gS/pcvfFsDPNtIId54Mrrz4MphvqYlHR+PRVGTFlEvfz0NgNzJSm3qBukkNtHPEFaVjWyrF1B0sA+T8L/dnHUdvwR3VMILV8hHlheQEk5M8eJwQOtNISrOjvcI/gzBpcp37AGKHJZvERDZTG4CfQbeiT0DF39LV09yD0Ye9/l4VphC1HQKWkBurV8ZeVD0TmNQBya5QX1ZBssGT2P8kkEnxbIQR/NirJXgLrYIasYiCwcvRJ6GqBdYs/UJx4dpN73UZvjYfSFUmG3oUmSZnhqKBGXSDtpdkCgYEA/qFqf3nWQ1WpywJaGCa2LEqg81J76HdBS7Lrz7Sft0+XJkjKCm9SNcmsqTk84ig+NeGk2CagE5wN1oBHfp+eyci0Nj5TFb2iEcqzUL4Qlc5AQMx1WvYf7BmmWfhMyh7vc4dvxHjFqskaRsyYpcvoZKjyfxxGlSJfw/eX7tvr5esCgYEA+E3YbEe0+lgqznrx85de3PiMruOBkM1qz6XNxud72jsIaxXyVtoJ3Lr2P1oBRxcSAtqXnXLpYpN4tFKVKEQ0/8c5svVK6us+ldSookxokLKNgTVPVkPZHBMyt0i9sEWVimaat08yy6gHSwXw10UX0yGQIlQ+OIz069Mt8W+yovUCgYAbvbJAmSGCzH5nI6Z1IyKNyMOoPsBJH1T5zlBqnJ8Z9Y3eGegJIv+t5H7vINFFQmUksaSn9+1QtZu8VtVzMii2iys3Das3nyVdEtxeW5aq+4F8jcnrUw0/R7wb6TVUf/JOf97pZM8EQEygkgG/bmuvK8jfmFEIRmpwizT+TO9yaQKBgQCyS5uTLO5MMRET0P55joEEpMjIL/7yTj5bOlCHeeLaMjd6RXkNWmVohSubE/ME7BD30aS63y+so/4xZXdLQabY32KUGUShaSg4iEpKuBkBheTMGc6NQAze9v4c0/O5Zk3Z4pFH/WuZB1+tRGfK/Ab+iQQpUlqXWsfnqm08B5u7HQKBgG1fm0p/4dWixrmiFsJe08qRlc0cxJ88tXYTPyjA1BtobUlEIa2sTu5QpJVQCWCDXc8yYf6TNZz4GfITqCq18sYzMpHELfQnkUx5tu4vujWomA2PYlaxtOJxREhvertOdGUCu7vHDeBB/k8PN7KJazpHtKhj+Z2RKu/4aoLigyCM",

        //异步通知地址
        'notify_url' => "http://www.wxshop1.com/alipay/notify",

        //同步跳转
        'return_url' => "http://www.wxshop1.com/alipay/return",

        //编码格式
        'charset' => "UTF-8",

        //签名方式
        'sign_type'=>"RSA2",

        //支付宝网关
        'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

        //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
        'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxrGjmnXaehVlGpmjPV5fV84fM6tZuxhz0XHHnDViz3NsbtDIIKFUvp/4kqYK7K+SM5BlmsaDWeYITjtZPqV0SCnPwMdzRvddRr4kxMdgYpm/nbRFar+LJEP274KqQtAgXYCZcgXqsLYXYDmE6a7Z7VpdEBTUklIk3A30Jp+4sPhcRXAygkYDjqhq9H5enUZRcJ62VX2tdpa/x1JyT5fEaxLqJI1AO5AjAOSt3Vceu79FVz3T+kjhEKKTknJtVP9YW/LrXyMDa0HfX/Ht3/an7+stmJ1kMTkysDTZZ8/gT/pKKeddP/xjy6qJ5tLvqT2VqRiSyKz09lHTS057aQSo6QIDAQAB",

];