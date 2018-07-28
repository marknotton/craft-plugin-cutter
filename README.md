<img src="http://i.imgur.com/oi2sSXg.png" alt="Snippet" align="left" height="60" />

# Snip *for Craft CMS*

> This plugin is no longer maintained. I'm committing to Craft 3 development only. Feel free to use the source code as you like. If you're looking for a Craft 3 version of this plugin, it's likely I've merged parts or all of this plugin into my [Helpers module.](https://github.com/marknotton/craft-module-helpers)

Similar to Truncate, only with more features like a snippet filter with smart fallbacks.

## Snip

Based on [Nizurs' Truncate plugin](https://github.com/nizur/Truncate); Snip essentially does the same thing with a few more options, plus the addition of a separate 'snippet' filter.

Any of the following filter aliases will call on the Snip filter:

```
{{ someText|truncate }}
{{ someText|cut }}
{{ someText|chars }}
{{ someText|words }}
```

The **words** filter forces the delimiter to 'words' and the default limit to 40 words.

#### **Settings**

| Parameters | Type   | Default | Description |
| ---------- | ------ | ------- | ----------- |
| Limit      | Number | 150     | Character/Word limit
| Suffix     | String | '…'     | Choose a string that should be added to the end; if truncation is required.
| Delimiter  | String | 'chars' | Truncate the given data by character ('chars') or word ('word') count.
| Strip HTML | Bool   | true    | Removes all HTML tags.

If you're coming from Nizurs truncate plugin, the same syntax can be used with my Snip filter. 

### Usage
Lets assume you have the following:

> {% set someText = 'Lorem ipsum <span>dolor sit amet</span>, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua' %}

#### Basic
```
{{ someText|snip(50) }}
```
#### Basic Output
```
Lorem ipsum dolor sit amet, consectetur adipiscing…
```
#### Advance
```
{{ someText|snip(10, 'words', '~', false) }}
```
#### Advance Output
```
Lorem ipsum <span>dolor sit amet</span>, consectetur adipiscing elit, sed do~
```

### Sentences

Assuming your text uses fullstops; you can truncate down to a specific number of sentences too:

```
{{ someText|sentences(2) }}
```

The **sentences** filter default limit is 2 sentences.

### Description

This is only intended for really bespoke cases. Developed primarily for the use of generating clean SEO safe descriptions, it essentially combines the character, word and sentence filters into one.

#### **Settings**
| Parameters      | Type   | Default | Description |
| --------------- | ------ | ------- | ----------- |
| Character Limit | Number | 150     | Limit the amount of characters before truncation. A max of 150 is recommended for SEO purposes.
| Word Limit      | Number | 20      | Limit the amount of words before truncation.
| Sentences Limit | Number | 2       | Limit the amount of sentences before truncation.
| Suffix          | String | '…'     | Choose a string that should be added to the end; if truncation is required.

```
{{ someText|description }}
{{ someText|description(100, 10, 1, '!') }}
```

----
## Snippet

Snippet is a filter that assumes there is a commonly used field which summerises an entry in the form of a snippet.

#### **Settings**

| Parameters      | Type   | Default   | Description |
| --------------- | ------ | --------- | ----------- |
| Limit           | Number | 20        | Character/Word limit
| Fallback handle | String | 'body'    | If this snippet isn't found, a fallback field will be truncated to supply a small sample of copy. If no fallback is found either, nothing will be output.
| Snippet handle  | String | 'snippet' | Snippet fieldtype handle
| Suffix          | String | '…'       | Choose a string that should be added to the end; if truncation is required.
| Delimiter       | String | 'words'   | Truncate the given data by character ('chars') or word ('word') count.
| ~~Strip HTML~~  | Bool   | true      | All HTML tags are removed. This can't be turned off.

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
