CREATE TABLE identifiers (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    uuid TEXT NOT NULL,
    ulid TEXT NOT NULL,
    binary_uuid BLOB NOT NULL,
    binary_ulid BLOB NOT NULL
);
