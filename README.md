# Rest Api php project
## How to use:

| Endpoint  | Return 
|--|--|
|country| { name: string; code: string } [ ] |
|country/{name-of-country}| { name: string; code: string } [ ] |
|country/by-name| { name: string; } [ ] |
|country/by-code| { code: string; } [ ] |

## Optional parameter:

| Optional  | input | 
|--|--|
|country?limit={range}|0 - infinite|
|country?ls={range}|A - M|

## Example:

    localhost/country/by-name?limit=4&ls=M

