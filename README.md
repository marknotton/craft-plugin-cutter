<img src="http://i.imgur.com/oi2sSXg.png" alt="Snippet" align="left" height="60" />

# Snip *for Craft CMS*

Similar to Truncate, only with more features like a snippet filter with smart fallbacks.

## Snip

Based on [Nizurs' Truncate plugin](https://github.com/nizur/Truncate); Snip essentially does the same thing with a few more options, plus the addition of a separate 'snippet' filter.

The Snip filter can also be referred to as, **truncate, cut, or chars, words**. The words filter forces the delimiter to 'words'.

#### **Settings**

| Parameters | Type   | Default | Description |
| ---------- | ------ | ------- | ----------- |
| Limit      | Number | 150     | Date format as per [**PHP Date**](http://php.net/manual/en/function.date.php)
| Suffix     | String | '…'     | Wrap each formatted element into a span. If the content is less than the char/word count, no suffix will be added.
| Delimiter  | String | 'chars' | Truncate the given data by character ('chars') or word ('word') count.
| Strip HTML | Bool   | true    | Removes all HTML tags.

It doesn't matter what order you use the parameters. The filter will figure the intended settings by the data type and content. Making this compatible with Nizurs syntax.

#### Basic Usage
```
{{ 'Lorem ipsum <span>dolor sit amet</span>, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua'|snip(50) }}
```
#### Basic Output
```
Lorem ipsum dolor sit amet, consectetur adipiscing…
```
#### Advance Usage
```
{{ 'Lorem ipsum <span>dolor sit amet</span>, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua'|snip(10, 'words', '~', false) }}
```
#### Advance Output
```
Lorem ipsum <span>dolor sit amet</span>, consectetur adipiscing elit, sed do~
```
----
## Snippet

Snippet is a filter that assumes there is a commonly used field which summerises an entry in the form of a snippet.

#### **Settings**

| Parameters      | Type   | Default   | Description |
| --------------- | ------ | --------- | ----------- |
| Limit           | Number | 20        | Date format as per [**PHP Date**](http://php.net/manual/en/function.date.php)
| Fallback handle | String | 'body'    | If this snippet isn't found, a fallback field will be truncated to supply a small sample of copy. If no fallback is found either, nothing will be output.
| Snippet handle  | String | 'snippet' | Snippet handle
| Suffix          | String | '…'       | Wrap each formatted element into a span. If the content is less than the char/word count, no suffix will be added.
| Delimiter       | String | 'words'   | Truncate the given data by character ('chars') or word ('word') count.
| ~~Strip HTML~~  | Bool   | true      | Removes all HTML tags. This is forced to be **true**

Not so similar to **snip**, *Limit*, *delimiter* and *strip HTML* parameters can be defined in any order. However the following must be defined in this order: *fallback handle*, *snippet*, and *suffix*.

### Example
Lets assume you have an entry with a body and a snippet with the following content:

##### Body example:
```html
<p>This is the bulk content of the page.</p>
<img src="/assets/images/logo.png">
<p>Lorem ipsum <span>dolor sit amet</span>, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
```
##### Snippet example:
```
This is a quick overview of what this entry is all about.
```
### Basic Usage
```
{{ entry|snippet(6) }}
```
### Basic Output
```
This is a quick overview of…
```
### Advance Usage
Now lets assume the snippet field was left blank...
```
{{ entry|snippet(20) }}
```
### Advance Output
```
This is the bulk content of the page. Lorem ipsum…
```
