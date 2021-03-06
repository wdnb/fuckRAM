--TEST--
yaml_emit - sequences
--SKIPIF--
<?php if(!extension_loaded('yaml')) die('skip yaml n/a'); ?>
--FILE--
<?php
$str = <<<EOD
This string was made with a here doc.

It contains embedded newlines.
  		It also has some embedded tabs.

Here are some symbols:
`~!@#$%^&*()_-+={}[]|\:";'<>,.?/

These are extended characters: Iñtërnâtiônàlizætiøn


EOD;
$doc = array(
    null,
    true,
    false,
    10,
    -10,
    123.456,
    -123.456,
    "yes",
    "no",
    "~",
    "-",
    "'",
    '"',
    "I\\xF1t\\xEBrn\\xE2ti\\xF4n\\xE0liz\\xE6ti\\xF8n",
    "# looks like a comment",
    "@looks_like_a_ref",
    "&looks_like_a_alias",
    "!!str",
    "%TAG ! tag:looks.like.one,999:",
    "!something",
    "Hello world!",
    "This is a string with\nan embedded newline.",
    $str,
  );
echo  "=== Array of scalars ===\n";
var_dump(yaml_emit($doc));

echo  "=== Nested ===\n";
var_dump(yaml_emit(array(
    "top level",
    array(
        "in array",
      ),
    array(
        "in array",
        array(
            "in array",
          ),
      ),
)));

echo  "=== Degenerate ===\n";
var_dump(yaml_emit(array()));

?>
--EXPECT--
=== Array of scalars ===
string(610) "---
- ~
- true
- false
- 10
- -10
- 123.456000
- -123.456000
- "yes"
- "no"
- "~"
- '-'
- ''''
- '"'
- I\xF1t\xEBrn\xE2ti\xF4n\xE0liz\xE6ti\xF8n
- '# looks like a comment'
- '@looks_like_a_ref'
- '&looks_like_a_alias'
- '!!str'
- '%TAG ! tag:looks.like.one,999:'
- '!something'
- Hello world!
- |-
  This is a string with
  an embedded newline.
- "This string was made with a here doc.\n\nIt contains embedded newlines.\n  \t\tIt
  also has some embedded tabs.\n\nHere are some symbols:\n`~!@#$%^&*()_-+={}[]|\\:\";'<>,.?/\n\nThese
  are extended characters: I\xF1t\xEBrn\xE2ti\xF4n\xE0liz\xE6ti\xF8n\n\n"
...
"
=== Nested ===
string(61) "---
- top level
- - in array
- - in array
  - - in array
...
"
=== Degenerate ===
string(11) "--- []
...
"
