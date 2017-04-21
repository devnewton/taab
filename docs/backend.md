Messages are returned in TSV format.

# TSV format

TSV is a simple UTF-8 text file with one record per line with fields separated by tabs.

```tsv
 ${id}\t${time}\t${info}\t${login}\t${message}\n
 ```

# Fields

## id

Numerical identifier of the message.

## time

Timestamp in YYYYMMDDhhmmss format in Europe/Paris timezone.

## info

User chosen information as a string field with any unicode character with a value >= 32.

## login

User chosen nickname as a string field with any unicode character with a value >= 32.

## message

Message as posted by the user as a string field with any unicode character with a value >= 32.

# Note

Backend providers can apply strictier policies than described above like string size limiting or additional character filtering.

Backend consumers MUST NOT rely on these specific policies.
