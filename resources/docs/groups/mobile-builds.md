# Mobile Builds


## Mettre à jour la version de build de l&#039;utilisateur

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/users/mobile-build-version" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/users/mobile-build-version"
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
    'http://localhost/api/users/mobile-build-version',
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
<div id="execution-results-PUTapi-users-mobile-build-version" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-users-mobile-build-version"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-users-mobile-build-version"></code></pre>
</div>
<div id="execution-error-PUTapi-users-mobile-build-version" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-users-mobile-build-version"></code></pre>
</div>
<form id="form-PUTapi-users-mobile-build-version" data-method="PUT" data-path="api/users/mobile-build-version" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-users-mobile-build-version', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/users/mobile-build-version</code></b>
</p>
<p>
<label id="auth-PUTapi-users-mobile-build-version" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-users-mobile-build-version" data-component="header"></label>
</p>
</form>


## api/mobile-build-version

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/mobile-build-version" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"build_number":"a","verified":false}'

```

```javascript
const url = new URL(
    "http://localhost/api/mobile-build-version"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "build_number": "a",
    "verified": false
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
    'http://localhost/api/mobile-build-version',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'build_number' => 'a',
            'verified' => false,
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (500):

```json
{
    "success": false,
    "message": "Une erreur s'est produite. Veuillez contacter votre administrateur.",
    "message_error": "Undefined index: REMOTE_ADDR"
}
```
<div id="execution-results-POSTapi-mobile-build-version" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-mobile-build-version"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-mobile-build-version"></code></pre>
</div>
<div id="execution-error-POSTapi-mobile-build-version" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-mobile-build-version"></code></pre>
</div>
<form id="form-POSTapi-mobile-build-version" data-method="POST" data-path="api/mobile-build-version" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-mobile-build-version', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/mobile-build-version</code></b>
</p>
<p>
<label id="auth-POSTapi-mobile-build-version" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-mobile-build-version" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>build_number</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="build_number" data-endpoint="POSTapi-mobile-build-version" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>verified</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-mobile-build-version" hidden><input type="radio" name="verified" value="true" data-endpoint="POSTapi-mobile-build-version" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-mobile-build-version" hidden><input type="radio" name="verified" value="false" data-endpoint="POSTapi-mobile-build-version" data-component="body" ><code>false</code></label>
<br>

</p>

</form>



