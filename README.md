# cortext-linkage - Dataset Linkage Module
Philippe Breucker, 11/2017

## General description

The Dataset Linkage Module (DLM) is designed to link datasets by various ways of matching records. Takes a list of entities to be matched, and a reference list with an id to be matched against. 
For every call to index.php, Importer class is creating a database (sqlite for now) with the 2 lists (in the data folder) imported as tables.
Matcher class is then called with a matching method (exact match only for now) and search the reference list for the name in the external list. It then produces a table of matching with the original entity name and the different matching in JSON format.
Linker class should then be called with parameters to select the best match for every entity, and produce a link table between external and reference table, with only ids.

## Requirements / Installation

In the current version, DLM is based only on php (5.5+) and Sqlite3 (with PHP Sqlite and PDO extension enabled). It can run via any web server without particular settings.
The parameters for the matcher can be set in the call for its construct, see index.php for exemple. You have to provide the matcher with the folowing informations:

- matchingAlgorithm: "exactMatch" for now
- refFieldToMatch: reference list field to match against
- externalFieldToMatch: external list field to match
- externalTable: external list custim table name (for now you have to use the name of the file with extension, in small caps without the special characters, eg. 'demoRef.csv' becomes 'demorefcsv' )
- refTable
- refIdField

## Todo

- Code Comments and documentation
- Finalize the Matcher class to produce table with id to id match, not only name (this implies that some sort of unique id is provided by the external list)
- Importer should take the params for creating tables
- Params should first be passed to dlm and then used by importer, matcher and linker
- Add multi column matching : columns should be in the params
- Implement Linking Engine
- Implment API calls for importing, creating matches and get linking results
- Handle accuracy: level of matching in the matching table, and threshold parameters for linking
- Finalize the abstract the query to database to avoid being database technology-dependant