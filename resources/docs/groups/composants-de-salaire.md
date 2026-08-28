# Composants de salaire


## Liste des composants de salaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/salary-componentsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"filter_value":"ea","pageItems":20,"nbreItems":3}'

```

```javascript
const url = new URL(
    "http://localhost/api/salary-componentsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "filter_value": "ea",
    "pageItems": 20,
    "nbreItems": 3
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
    'http://localhost/api/salary-componentsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'filter_value' => 'ea',
            'pageItems' => 20,
            'nbreItems' => 3,
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
<div id="execution-results-POSTapi-salary-componentsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-salary-componentsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-salary-componentsall"></code></pre>
</div>
<div id="execution-error-POSTapi-salary-componentsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-salary-componentsall"></code></pre>
</div>
<form id="form-POSTapi-salary-componentsall" data-method="POST" data-path="api/salary-componentsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-salary-componentsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/salary-componentsall</code></b>
</p>
<p>
<label id="auth-POSTapi-salary-componentsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-salary-componentsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-salary-componentsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-salary-componentsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-salary-componentsall" data-component="body"  hidden>
<br>

</p>

</form>


## Création d&#039;un composant de salaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/salary-components" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"salary_components":[{"name":"velit","code":"modi","type":"quidem","order":1}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/salary-components"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "salary_components": [
        {
            "name": "velit",
            "code": "modi",
            "type": "quidem",
            "order": 1
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
    'http://localhost/api/salary-components',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'salary_components' => [
                [
                    'name' => 'velit',
                    'code' => 'modi',
                    'type' => 'quidem',
                    'order' => 1,
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
<div id="execution-results-POSTapi-salary-components" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-salary-components"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-salary-components"></code></pre>
</div>
<div id="execution-error-POSTapi-salary-components" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-salary-components"></code></pre>
</div>
<form id="form-POSTapi-salary-components" data-method="POST" data-path="api/salary-components" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-salary-components', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/salary-components</code></b>
</p>
<p>
<label id="auth-POSTapi-salary-components" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-salary-components" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>salary_components</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>salary_components[].name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="salary_components.0.name" data-endpoint="POSTapi-salary-components" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>salary_components[].code</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="salary_components.0.code" data-endpoint="POSTapi-salary-components" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>salary_components[].type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="salary_components.0.type" data-endpoint="POSTapi-salary-components" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>salary_components[].order</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="salary_components.0.order" data-endpoint="POSTapi-salary-components" data-component="body"  hidden>
<br>

</p>
</details>
</p>

</form>


## Détails d&#039;un composant de salaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/salary-components/voluptatem" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/salary-components/voluptatem"
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
    'http://localhost/api/salary-components/voluptatem',
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
<div id="execution-results-GETapi-salary-components--salary_component-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-salary-components--salary_component-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-salary-components--salary_component-"></code></pre>
</div>
<div id="execution-error-GETapi-salary-components--salary_component-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-salary-components--salary_component-"></code></pre>
</div>
<form id="form-GETapi-salary-components--salary_component-" data-method="GET" data-path="api/salary-components/{salary_component}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-salary-components--salary_component-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/salary-components/{salary_component}</code></b>
</p>
<p>
<label id="auth-GETapi-salary-components--salary_component-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-salary-components--salary_component-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>salary_component</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="salary_component" data-endpoint="GETapi-salary-components--salary_component-" data-component="url" required  hidden>
<br>

</p>
</form>


## api/salary-components/{salary_component}

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/salary-components/veniam" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"et","code":"qui","type":"eos","order":3}'

```

```javascript
const url = new URL(
    "http://localhost/api/salary-components/veniam"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "et",
    "code": "qui",
    "type": "eos",
    "order": 3
}

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'http://localhost/api/salary-components/veniam',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'et',
            'code' => 'qui',
            'type' => 'eos',
            'order' => 3,
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
<div id="execution-results-PUTapi-salary-components--salary_component-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-salary-components--salary_component-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-salary-components--salary_component-"></code></pre>
</div>
<div id="execution-error-PUTapi-salary-components--salary_component-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-salary-components--salary_component-"></code></pre>
</div>
<form id="form-PUTapi-salary-components--salary_component-" data-method="PUT" data-path="api/salary-components/{salary_component}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-salary-components--salary_component-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/salary-components/{salary_component}</code></b>
</p>
<p>
<label id="auth-PUTapi-salary-components--salary_component-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-salary-components--salary_component-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>salary_component</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="salary_component" data-endpoint="PUTapi-salary-components--salary_component-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-salary-components--salary_component-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>code</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="code" data-endpoint="PUTapi-salary-components--salary_component-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="PUTapi-salary-components--salary_component-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>order</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="order" data-endpoint="PUTapi-salary-components--salary_component-" data-component="body"  hidden>
<br>

</p>

</form>


## Mise en corbeille d&#039;un composant de salaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/salary-components/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[10,7]}'

```

```javascript
const url = new URL(
    "http://localhost/api/salary-components/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        10,
        7
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
    'http://localhost/api/salary-components/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                10,
                7,
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
<div id="execution-results-POSTapi-salary-components-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-salary-components-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-salary-components-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-salary-components-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-salary-components-trash"></code></pre>
</div>
<form id="form-POSTapi-salary-components-trash" data-method="POST" data-path="api/salary-components/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-salary-components-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/salary-components/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-salary-components-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-salary-components-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-salary-components-trash" data-component="body" required  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-salary-components-trash" data-component="body" hidden>
<br>

</p>

</form>


## Restauration d&#039;un composant de salaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/salary-components/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[15,13]}'

```

```javascript
const url = new URL(
    "http://localhost/api/salary-components/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        15,
        13
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
    'http://localhost/api/salary-components/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                15,
                13,
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
<div id="execution-results-POSTapi-salary-components-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-salary-components-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-salary-components-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-salary-components-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-salary-components-restore"></code></pre>
</div>
<form id="form-POSTapi-salary-components-restore" data-method="POST" data-path="api/salary-components/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-salary-components-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/salary-components/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-salary-components-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-salary-components-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-salary-components-restore" data-component="body" required  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-salary-components-restore" data-component="body" hidden>
<br>

</p>

</form>


## Suppression définitive d&#039;un composant de salaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/salary-components/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[18,20]}'

```

```javascript
const url = new URL(
    "http://localhost/api/salary-components/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        18,
        20
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
    'http://localhost/api/salary-components/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                18,
                20,
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
<div id="execution-results-POSTapi-salary-components-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-salary-components-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-salary-components-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-salary-components-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-salary-components-delete"></code></pre>
</div>
<form id="form-POSTapi-salary-components-delete" data-method="POST" data-path="api/salary-components/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-salary-components-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/salary-components/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-salary-components-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-salary-components-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-salary-components-delete" data-component="body" required  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-salary-components-delete" data-component="body" hidden>
<br>

</p>

</form>



