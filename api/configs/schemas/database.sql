CREATE TABLE accounts(
  id INTEGER PRIMARY KEY,
  name TEXT
);

CREATE TABLE systems(
  id INTEGER PRIMARY KEY,
  account_id INTEGER REFERENCES accounts(id),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  name TEXT,
  schema TEXT
);
CREATE INDEX index_system_name ON systems(name);

CREATE TABLE profiles(
  id INTEGER PRIMARY KEY,
  system_id INTEGER REFERENCES systems(id),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  name TEXT,
  key TEXT
);
CREATE INDEX index_profile_name ON profiles(name);

CREATE TABLE configs(
  id INTEGER PRIMARY KEY,
  profile_id INTEGER REFERENCES profiles(id),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  data TEXT
);

CREATE TABLE clients(
  id INTEGER PRIMARY KEY,
  account_id INTEGER REFERENCES accounts(id),
  name TEXT,
  key TEXT,
  requires_auth_token BOOLEAN DEFAULT FALSE
);
CREATE INDEX index_client_name ON clients(name);

CREATE TABLE client_auth_tokens(
  id INTEGER PRIMARY KEY,
  client_id INTEGER REFERENCES clients(id),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  value TEXT
);

CREATE TABLE client_requests(
  id INTEGER PRIMARY KEY,
  client_id INTEGER REFERENCES clients(id),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  method TEXT,
  uri TEXT,
  headers TEXT,
  params TEXT
);

