<?php
/**
* COOKIES DO LADO DO SERVER (SERVIDOR)
 */

$cookies = $_COOKIE;
var_dump($cookies);//Todos os cookies
var_dump($cookies['cookies_accepted'] ?? null); //Obtém o cookie 'cookies_accepte'

function setPreferences($accept = true)
{
    $preferences = [
        'color'      => 'red',
        'background' => 'yellow',
    ];

    foreach ($preferences as $k => $v)
    {
        if ($accept)
            setcookie($k, $v, time() + 3600);
        else
            setcookie($k, $v, time() - 3600);
    }
}

$cookies_accepted = in_array(strtolower($cookies['cookies_accepted']), ['true', true], true);

if ($cookies_accepted)
{
    echo "Política de cookies aceitas";
    setPreferences();
} else
{
    echo "Política de cookies NÃO aceitas";
    setPreferences(false);
}

if ($cookies_accepted)
{
    $color      = $cookies['color']         ?? "green";
    $background = $cookies['background']    ?? "black";
} else {
    $color      = "pink";
    $background = "gray";
}
?>

<div id="preferences" <?= "style='color:$color;background:$background' " ?>>
    Lorem ipsum dolor sit amet consectetur adipisicing elit. Error exercitationem perferendis dolore eligendi velit libero dolorum tempora atque obcaecati aliquid! Reprehenderit, deleniti saepe blanditiis doloribus mollitia quae dolor qui quasi?
</div>

<br>

<div>
    <p>Selecione suas preferências</p>
    <label for="basico"><input type="checkbox" id="basico" disabled readonly checked> Basico </label><br>
    <label for="desempenho"><input type="checkbox" id="desempenho"> Desempenho </label><br>
    <label for="customizacoes"><input type="checkbox" id="customizacoes"> Customizacoes </label><br>
    <button id="cookies_set_save">Salvar</button>
</div>

<br>

<button onclick="setCookie('cookies_accepted', 'true')">Aceitar Cookies</button>
<button onclick="setCookie('cookies_accepted', 'false')">Recusar Cookies</button>

<script>
    /**
    * COOKIES DO LADO DO CLIENTE (NAVEGADOR)
     */


    /**
     * Armazena um cookie onde "name" é a chave e "value" o valor deste e "days" é a validade em dias
     * "name" precisa ser uma string
     * "value" precisa ser uma string
     * "days" precisa ser um integer (inteiro)
    */
    function setCookie(name, value, days)
    {
        var expires = "";
        if (days)
        {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }


    /**
     * Exclui o cookie passado por parâmetro passando uma data no passado
     * "name" precisa ser uma string
    */
    function forgetCookie(name)
    {
        var expires = "";
        var date = new Date('1970-10-10');
        date.setTime(date.getTime());
        expires = "; expires=" + date.toUTCString();
        document.cookie = name + "=" + "" + expires + "; path=/";
    }

    /**
    * Verifica se um retorno não é "undefined"
     */
    function notUndefined(variable)
    {
        return typeof(variable) !== "undefined";
    }

    /**
    * Pega um valor e retorna um boolean
    */
    function binaryValue(value)
    {
        value = value == '0' || value == null || value == 'false' 
                || value == false ? false : value;

        value = value == '0' || value == '1' || value == null || value == 'false' 
                || value == 'true' || value == false || value == true ? value : false;

        value = value == '1' || value == true || value == 'true' ? true : false;

        return value;
    }

    /**
     * Obtém o cookie passado por parâmetro
     * "name" precisa ser uma string
    */
    function getCookie(name)
    {
        var nameEQ = name + "=";
        var ca     = document.cookie.split(';');

        for (var i = 0; i < ca.length; i++)
        {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    document.querySelector('#cookies_set_save').addEventListener('click', (ev) => {
        var basico        = document.querySelector('input#basico')?.checked           ? '1' : '1';//Sempre marcado
        var desempenho    = document.querySelector('input#desempenho')?.checked       ? '1' : '0';
        var customizacoes = document.querySelector('input#customizacoes')?.checked    ? '1' : '0';

        var lgpd = [basico, desempenho, customizacoes].join('|');
        setCookie('lgpd', lgpd, 365);
    });

    window.addEventListener('load', (e) => {
        var lgpd_cookie   = getCookie('lgpd')?.split('|');
            lgpd_cookie   = notUndefined(lgpd_cookie) && lgpd_cookie.length == 3 ? lgpd_cookie : ['1', '1', '1'];
            basico        = binaryValue(lgpd_cookie[0]);
            desempenho    = binaryValue(lgpd_cookie[1]);
            customizacoes = binaryValue(lgpd_cookie[2]);

        if(document.querySelector('input#basico'))
            document.querySelector('input#basico').checked = true;

        if(document.querySelector('input#desempenho'))
            document.querySelector('input#desempenho').checked = desempenho ? true : false;

        if(document.querySelector('input#customizacoes'))
            document.querySelector('input#customizacoes').checked = customizacoes ? true : false;
    });
</script>

<script>
    //-------------------- EXEMPLOS ---------------------------//
    //---- Essa parte são exemplos de uso           -----------//
    //---- não são importantes para o funcionamento -----------//
    //---------------------------------------------------------//

    //Utilizando o setCookie() com um valor válido por 30 dias
    setCookie("cookie_via_js", "valor do cookie", 30);

    //Recuperando o cookie setado acima
    var cookie_via_js = getCookie("cookie_via_js");
    //Imprimindo o valor obtido e imprimindo no console.log()
    console.log('cookie_via_js', cookie_via_js);

    //Excluindo o cookie
    forgetCookie("cookie_via_js");

    //------------------- FIM DOS EXEMPLOS --------------------//
</script>