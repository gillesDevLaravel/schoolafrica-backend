# Pension


## api/pensiontranchefee

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/pensiontranchefee" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idLevel":"autem","idSchool":"et","idSection":"earum"}'

```

```javascript
const url = new URL(
    "http://localhost/api/pensiontranchefee"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idLevel": "autem",
    "idSchool": "et",
    "idSection": "earum"
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
    'http://localhost/api/pensiontranchefee',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idLevel' => 'autem',
            'idSchool' => 'et',
            'idSection' => 'earum',
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
<div id="execution-results-POSTapi-pensiontranchefee" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-pensiontranchefee"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-pensiontranchefee"></code></pre>
</div>
<div id="execution-error-POSTapi-pensiontranchefee" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-pensiontranchefee"></code></pre>
</div>
<form id="form-POSTapi-pensiontranchefee" data-method="POST" data-path="api/pensiontranchefee" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-pensiontranchefee', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/pensiontranchefee</code></b>
</p>
<p>
<label id="auth-POSTapi-pensiontranchefee" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-pensiontranchefee" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idLevel</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idLevel" data-endpoint="POSTapi-pensiontranchefee" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idSchool" data-endpoint="POSTapi-pensiontranchefee" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idSection" data-endpoint="POSTapi-pensiontranchefee" data-component="body" required  hidden>
<br>

</p>

</form>


## Listing des pensions

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/pensionsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":4,"idSection":5,"idTypeOfRecipe":16,"idPension":6,"idTranche":14,"idStudent":14,"idClasse":3,"date":{},"date_start":{},"date_end":{},"payment_mode":{}}'

```

```javascript
const url = new URL(
    "http://localhost/api/pensionsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 4,
    "idSection": 5,
    "idTypeOfRecipe": 16,
    "idPension": 6,
    "idTranche": 14,
    "idStudent": 14,
    "idClasse": 3,
    "date": {},
    "date_start": {},
    "date_end": {},
    "payment_mode": {}
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
    'http://localhost/api/pensionsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 4,
            'idSection' => 5,
            'idTypeOfRecipe' => 16,
            'idPension' => 6,
            'idTranche' => 14,
            'idStudent' => 14,
            'idClasse' => 3,
            'date' => [],
            'date_start' => [],
            'date_end' => [],
            'payment_mode' => [],
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
<div id="execution-results-POSTapi-pensionsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-pensionsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-pensionsall"></code></pre>
</div>
<div id="execution-error-POSTapi-pensionsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-pensionsall"></code></pre>
</div>
<form id="form-POSTapi-pensionsall" data-method="POST" data-path="api/pensionsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-pensionsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/pensionsall</code></b>
</p>
<p>
<label id="auth-POSTapi-pensionsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-pensionsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-pensionsall" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-pensionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTypeOfRecipe</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTypeOfRecipe" data-endpoint="POSTapi-pensionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idPension</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idPension" data-endpoint="POSTapi-pensionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTranche</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTranche" data-endpoint="POSTapi-pensionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-pensionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-pensionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="POSTapi-pensionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date_start</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_start" data-endpoint="POSTapi-pensionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date_end</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_end" data-endpoint="POSTapi-pensionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>payment_mode</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="payment_mode" data-endpoint="POSTapi-pensionsall" data-component="body"  hidden>
<br>

</p>

</form>


## Afficher les détails d&#039;une pension

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/pensions/sint" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/pensions/sint"
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
    'http://localhost/api/pensions/sint',
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
<div id="execution-results-GETapi-pensions--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-pensions--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-pensions--id-"></code></pre>
</div>
<div id="execution-error-GETapi-pensions--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-pensions--id-"></code></pre>
</div>
<form id="form-GETapi-pensions--id-" data-method="GET" data-path="api/pensions/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-pensions--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/pensions/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-pensions--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-pensions--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-pensions--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Ajouter une pension

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/pensions" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pensions":[{"name":"quod","price":9,"nbrTranche":19,"idLevel":6,"idTypeOfRecipe":8}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/pensions"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pensions": [
        {
            "name": "quod",
            "price": 9,
            "nbrTranche": 19,
            "idLevel": 6,
            "idTypeOfRecipe": 8
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
    'http://localhost/api/pensions',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pensions' => [
                [
                    'name' => 'quod',
                    'price' => 9,
                    'nbrTranche' => 19,
                    'idLevel' => 6,
                    'idTypeOfRecipe' => 8,
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
<div id="execution-results-POSTapi-pensions" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-pensions"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-pensions"></code></pre>
</div>
<div id="execution-error-POSTapi-pensions" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-pensions"></code></pre>
</div>
<form id="form-POSTapi-pensions" data-method="POST" data-path="api/pensions" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-pensions', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/pensions</code></b>
</p>
<p>
<label id="auth-POSTapi-pensions" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-pensions" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>pensions</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>pensions[].name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="pensions.0.name" data-endpoint="POSTapi-pensions" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pensions[].price</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="pensions.0.price" data-endpoint="POSTapi-pensions" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>pensions[].nbrTranche</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="pensions.0.nbrTranche" data-endpoint="POSTapi-pensions" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>pensions[].idLevel</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="pensions.0.idLevel" data-endpoint="POSTapi-pensions" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>pensions[].idTypeOfRecipe</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pensions.0.idTypeOfRecipe" data-endpoint="POSTapi-pensions" data-component="body"  hidden>
<br>

</p>
</details>
</p>

</form>


## maj des infos d&#039;une pension
{
&quot;name&quot;: &quot;Registration&quot;,&quot;price&quot;: 25000, //Modifier le prix pour voir les differents cas &quot;deadline&quot;: &quot;2024-09-02&quot;,&quot;idSchool&quot;: 2,&quot;idSection&quot;: 2}

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/pensions/et" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/pensions/et"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "PUT",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'http://localhost/api/pensions/et',
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
<div id="execution-results-PUTapi-pensions--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-pensions--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-pensions--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-pensions--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-pensions--id-"></code></pre>
</div>
<form id="form-PUTapi-pensions--id-" data-method="PUT" data-path="api/pensions/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-pensions--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/pensions/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-pensions--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-pensions--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-pensions--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Supprimer une pension
&quot;name&quot;: &quot;Registration&quot;,&quot;price&quot;: 25000, //Modifier le prix pour voir les differents cas &quot;deadline&quot;: &quot;2024-09-02&quot;,&quot;idSchool&quot;: 2,&quot;idSection&quot;: 2}

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/pensions/recusandae" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/pensions/recusandae"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'http://localhost/api/pensions/recusandae',
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
<div id="execution-results-DELETEapi-pensions--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-pensions--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-pensions--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-pensions--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-pensions--id-"></code></pre>
</div>
<form id="form-DELETEapi-pensions--id-" data-method="DELETE" data-path="api/pensions/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-pensions--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/pensions/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-pensions--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-pensions--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-pensions--id-" data-component="url" required  hidden>
<br>

</p>
</form>



