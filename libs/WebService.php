<?php
class WebService
{

    public function sendPost($url, $data)
    {
        //url contra la que atacamos
        $ch = curl_init($url);
        //a true, obtendremos una respuesta de la url, en otro caso,
        //true si es correcto, false si no lo es
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //establecemos el verbo http que queremos utilizar para la petición
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        //enviamos el array data
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        //obtenemos la respuesta
        $response = curl_exec($ch);

        // Se cierra el recurso CURL y se liberan los recursos del sistema
        curl_close($ch);
        if (!$response) {
            return false;
        }
        return $this->responseDecode($response);
    }

    public function sendPut($url, $data)
    {
        //url contra la que atacamos
        $ch = curl_init($url);
        //a true, obtendremos una respuesta de la url, en otro caso,
        //true si es correcto, false si no lo es
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //establecemos el verbo http que queremos utilizar para la petición
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        //enviamos el array data
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        //obtenemos la respuesta
        $response = curl_exec($ch);
        // Se cierra el recurso CURL y se liberan los recursos del sistema
        curl_close($ch);
        if (!$response) {
            return false;
        }
        return $this->responseDecode($response);
    }

    public function sendGet($url, $data)
    {
        //url contra la que atacamos
        $ch = curl_init($url);
        //a true, obtendremos una respuesta de la url, en otro caso,
        //true si es correcto, false si no lo es
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //establecemos el verbo http que queremos utilizar para la petición
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        //enviamos el array data
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        //obtenemos la respuesta
        $response = curl_exec($ch);
        // Se cierra el recurso CURL y se liberan los recursos del sistema
        curl_close($ch);
        if (!$response) {
            return false;
        }
        return $this->responseDecode($response);
    }

    public function sendDelete($url, $data)
    {
        //url contra la que atacamos
        $ch = curl_init($url);
        //a true, obtendremos una respuesta de la url, en otro caso,
        //true si es correcto, false si no lo es
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //establecemos el verbo http que queremos utilizar para la petición
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        //enviamos el array data
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        //obtenemos la respuesta
        $response = curl_exec($ch);
        // Se cierra el recurso CURL y se liberan los recursos del sistema
        curl_close($ch);
        if (!$response) {
            return false;
        }
        return $this->responseDecode($response);
    }

    private function responseDecode($response)
    {
        return json_decode($response);
    }
}
