# Permissions


## Créer une permission

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/permissions" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"permissions":[{"name":"impedit","ressource":"recusandae","description":"et"}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/permissions"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "permissions": [
        {
            "name": "impedit",
            "ressource": "recusandae",
            "description": "et"
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
    'http://localhost/api/permissions',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'permissions' => [
                [
                    'name' => 'impedit',
                    'ressource' => 'recusandae',
                    'description' => 'et',
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
<div id="execution-results-POSTapi-permissions" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-permissions"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-permissions"></code></pre>
</div>
<div id="execution-error-POSTapi-permissions" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-permissions"></code></pre>
</div>
<form id="form-POSTapi-permissions" data-method="POST" data-path="api/permissions" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-permissions', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/permissions</code></b>
</p>
<p>
<label id="auth-POSTapi-permissions" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-permissions" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>permissions</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>permissions[].name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="permissions.0.name" data-endpoint="POSTapi-permissions" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>permissions[].ressource</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="permissions.0.ressource" data-endpoint="POSTapi-permissions" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>permissions[].description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="permissions.0.description" data-endpoint="POSTapi-permissions" data-component="body" required  hidden>
<br>

</p>
</details>
</p>

</form>


## Récupérer la liste de permissions

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/permissions" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/permissions"
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
    'http://localhost/api/permissions',
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
<div id="execution-results-GETapi-permissions" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-permissions"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-permissions"></code></pre>
</div>
<div id="execution-error-GETapi-permissions" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-permissions"></code></pre>
</div>
<form id="form-GETapi-permissions" data-method="GET" data-path="api/permissions" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-permissions', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/permissions</code></b>
</p>
<p>
<label id="auth-GETapi-permissions" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-permissions" data-component="header"></label>
</p>
</form>


## maj des infos d&#039;une permission

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/permissions/4" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"permissions":[{"name":"veniam","ressource":"corrupti","description":"quos"}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/permissions/4"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "permissions": [
        {
            "name": "veniam",
            "ressource": "corrupti",
            "description": "quos"
        }
    ]
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
    'http://localhost/api/permissions/4',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'permissions' => [
                [
                    'name' => 'veniam',
                    'ressource' => 'corrupti',
                    'description' => 'quos',
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
<div id="execution-results-PUTapi-permissions--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-permissions--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-permissions--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-permissions--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-permissions--id-"></code></pre>
</div>
<form id="form-PUTapi-permissions--id-" data-method="PUT" data-path="api/permissions/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-permissions--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/permissions/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-permissions--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-permissions--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="id" data-endpoint="PUTapi-permissions--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>permissions</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>permissions[].name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="permissions.0.name" data-endpoint="PUTapi-permissions--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>permissions[].ressource</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="permissions.0.ressource" data-endpoint="PUTapi-permissions--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>permissions[].description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="permissions.0.description" data-endpoint="PUTapi-permissions--id-" data-component="body" required  hidden>
<br>

</p>
</details>
</p>

</form>


## Supprimer une permission (si elle n&#039;est pas attribuée à un role)

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/permissions/2" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/permissions/2"
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
    'http://localhost/api/permissions/2',
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
<div id="execution-results-DELETEapi-permissions--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-permissions--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-permissions--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-permissions--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-permissions--id-"></code></pre>
</div>
<form id="form-DELETEapi-permissions--id-" data-method="DELETE" data-path="api/permissions/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-permissions--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/permissions/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-permissions--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-permissions--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="id" data-endpoint="DELETEapi-permissions--id-" data-component="url" required  hidden>
<br>

</p>
</form>



