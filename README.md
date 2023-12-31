
# Symphony Console Command

This project is simple console command that could parse some html tags.

## Initialization

```
1. Clone the repo and open project folder
2. run composer init from Terminal
3. Make sure that `bin/console` file have executive rights
```

## General Description

Script can accept two arguments as input:

`html` - piece of valid html that should be parsed, please wrap your HTML chunk with quotes

`lang` - ISO Language code one of `['en', 'uk', 'de', 'fr']`

To execute this command You can run something like:

```
bin/console parse '<span>Текст</span><div>Інший текст</div>' uk
```

During the execution You will be asked for choosing translation language and providing translations for every parsed text from HTML input.

Follow the instructions to make it happen =)

currently supported tags:
```
[ "p", "h1", "h2", "h3", "h4", "h5", "h6", "span", "a",
    "strong", "em", "blockquote", "pre", "cite", "code", "abbr",
    "label", "li", "figcaption", "summary", "button", "time", "q",
    "del", "ins", "sub", "sup", "dfn", "var", "kbd", "samp", "text", "div"
]
```





