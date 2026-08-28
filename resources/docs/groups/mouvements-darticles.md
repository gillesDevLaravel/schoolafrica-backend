# Mouvements d'articles

Gestion des mouvements d'articles

## Lister les mouvements d&#039;article en fonction du filtre

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/article-movementsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pageItems":7,"nbreItems":15,"filter_value":"voluptates","article_id":3,"operation_type":"exit","from_date":"2025-11-22T14:46:52+0000","to_date":"2025-11-22T14:46:52+0000"}'

```

```javascript
const url = new URL(
    "http://localhost/api/article-movementsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pageItems": 7,
    "nbreItems": 15,
    "filter_value": "voluptates",
    "article_id": 3,
    "operation_type": "exit",
    "from_date": "2025-11-22T14:46:52+0000",
    "to_date": "2025-11-22T14:46:52+0000"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/article-movementsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pageItems' => 7,
            'nbreItems' => 15,
            'filter_value' => 'voluptates',
            'article_id' => 3,
            'operation_type' => 'exit',
            'from_date' => '2025-11-22T14:46:52+0000',
            'to_date' => '2025-11-22T14:46:52+0000',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-POSTapi-article-movementsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-article-movementsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-article-movementsall"></code></pre>
</div>
<div id="execution-error-POSTapi-article-movementsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-article-movementsall"></code></pre>
</div>
<form id="form-POSTapi-article-movementsall" data-method="POST" data-path="api/article-movementsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-article-movementsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/article-movementsall</code></b>
</p>
<p>
<label id="auth-POSTapi-article-movementsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-article-movementsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-article-movementsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-article-movementsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-article-movementsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>article_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="article_id" data-endpoint="POSTapi-article-movementsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>operation_type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="operation_type" data-endpoint="POSTapi-article-movementsall" data-component="body"  hidden>
<br>
The value must be one of <code>entry</code> or <code>exit</code>.
</p>
<p>
<b><code>from_date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="from_date" data-endpoint="POSTapi-article-movementsall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>to_date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="to_date" data-endpoint="POSTapi-article-movementsall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>

</form>


## Ajouter mutiple des mouvements d&#039;article

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/article-movements" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"article_movements":[{"quantity":1,"reason":"suscipit","date":"2025-11-22T14:46:52+0000","description":"vero","operation_type":"exit","idUser":13,"article_id":19,"purchase_order_id":1}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/article-movements"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "article_movements": [
        {
            "quantity": 1,
            "reason": "suscipit",
            "date": "2025-11-22T14:46:52+0000",
            "description": "vero",
            "operation_type": "exit",
            "idUser": 13,
            "article_id": 19,
            "purchase_order_id": 1
        }
    ]
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/article-movements',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'article_movements' => [
                [
                    'quantity' => 1,
                    'reason' => 'suscipit',
                    'date' => '2025-11-22T14:46:52+0000',
                    'description' => 'vero',
                    'operation_type' => 'exit',
                    'idUser' => 13,
                    'article_id' => 19,
                    'purchase_order_id' => 1,
                ],
            ],
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-POSTapi-article-movements" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-article-movements"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-article-movements"></code></pre>
</div>
<div id="execution-error-POSTapi-article-movements" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-article-movements"></code></pre>
</div>
<form id="form-POSTapi-article-movements" data-method="POST" data-path="api/article-movements" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-article-movements', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/article-movements</code></b>
</p>
<p>
<label id="auth-POSTapi-article-movements" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-article-movements" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>article_movements</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>article_movements[].quantity</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="article_movements.0.quantity" data-endpoint="POSTapi-article-movements" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>article_movements[].reason</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="article_movements.0.reason" data-endpoint="POSTapi-article-movements" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>article_movements[].date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="article_movements.0.date" data-endpoint="POSTapi-article-movements" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>article_movements[].description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="article_movements.0.description" data-endpoint="POSTapi-article-movements" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>article_movements[].operation_type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="article_movements.0.operation_type" data-endpoint="POSTapi-article-movements" data-component="body" required  hidden>
<br>
The value must be one of <code>entry</code>, <code>exit</code>, <code>rental_entry</code>, or <code>rental_exit</code>.
</p>
<p>
<b><code>article_movements[].idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="article_movements.0.idUser" data-endpoint="POSTapi-article-movements" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>article_movements[].article_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="article_movements.0.article_id" data-endpoint="POSTapi-article-movements" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>article_movements[].purchase_order_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="article_movements.0.purchase_order_id" data-endpoint="POSTapi-article-movements" data-component="body"  hidden>
<br>

</p>
</details>
</p>

</form>


## Afficher un mouvement d&#039;article spécifique

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/article-movements/veritatis" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/article-movements/veritatis"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/article-movements/veritatis',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-GETapi-article-movements--article-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-article-movements--article-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-article-movements--article-"></code></pre>
</div>
<div id="execution-error-GETapi-article-movements--article-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-article-movements--article-"></code></pre>
</div>
<form id="form-GETapi-article-movements--article-" data-method="GET" data-path="api/article-movements/{article}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-article-movements--article-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/article-movements/{article}</code></b>
</p>
<p>
<label id="auth-GETapi-article-movements--article-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-article-movements--article-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>article</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="article" data-endpoint="GETapi-article-movements--article-" data-component="url" required  hidden>
<br>

</p>
</form>



