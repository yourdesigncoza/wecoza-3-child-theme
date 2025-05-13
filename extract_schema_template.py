#!/usr/bin/env python3
"""
PostgreSQL Schema Extraction Script
Connects to the database and extracts schema manually
"""

import psycopg2
import sys
from datetime import datetime

# Database connection parameters
host = 'YOUR_HOST'
port = 'YOUR_PORT'
dbname = 'YOUR_DATABASE'
user = 'YOUR_USERNAME'
password = 'YOUR_PASSWORD'

# Output file
schema_file = 'database_schema.sql'

try:
    # Connect to the database
    conn_string = f"host={host} port={port} dbname={dbname} user={user} password={password} sslmode=require"
    conn = psycopg2.connect(conn_string)
    cursor = conn.cursor()

    print("Connected to PostgreSQL database successfully!\n")

    # Get list of all tables
    cursor.execute("""
        SELECT table_name
        FROM information_schema.tables
        WHERE table_schema = 'public'
        ORDER BY table_name;
    """)

    tables = [row[0] for row in cursor.fetchall()]

    print(f"Found {len(tables)} tables in the database.\n")

    # Create schema file
    with open(schema_file, 'w') as f:
        # Write header
        f.write(f"-- PostgreSQL Database Schema Export\n")
        f.write(f"-- Generated on: {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}\n")
        f.write(f"-- Database: {dbname}\n\n")

        # Process each table
        for table in tables:
            print(f"Processing table: {table}")

            # Get table columns
            cursor.execute("""
                SELECT
                    column_name,
                    data_type,
                    character_maximum_length,
                    column_default,
                    is_nullable
                FROM
                    information_schema.columns
                WHERE
                    table_schema = 'public' AND table_name = %s
                ORDER BY
                    ordinal_position;
            """, (table,))

            columns = cursor.fetchall()

            # Build CREATE TABLE statement
            create_table = f"CREATE TABLE {table} (\n"

            for i, col in enumerate(columns):
                column_name = col[0]
                data_type = col[1]
                max_length = col[2]
                default_val = col[3]
                is_nullable = col[4]

                # Handle data type with length
                if max_length is not None:
                    data_type = f"{data_type}({max_length})"

                # Add NOT NULL if required
                nullable = "" if is_nullable == 'YES' else " NOT NULL"

                # Add default value if exists
                default = f" DEFAULT {default_val}" if default_val is not None else ""

                # Add comma if not the last column
                comma = "," if i < len(columns) - 1 else ""

                create_table += f"    {column_name} {data_type}{nullable}{default}{comma}\n"

            create_table += ");"

            # Write to schema file
            f.write(f"-- Table: {table}\n")
            f.write(f"{create_table}\n\n")

            # Get primary key constraints
            cursor.execute("""
                SELECT
                    kcu.column_name
                FROM
                    information_schema.table_constraints tc
                    JOIN information_schema.key_column_usage kcu
                        ON tc.constraint_name = kcu.constraint_name
                WHERE
                    tc.constraint_type = 'PRIMARY KEY'
                    AND tc.table_name = %s;
            """, (table,))

            pk_columns = cursor.fetchall()

            if pk_columns:
                pk_cols = ', '.join([col[0] for col in pk_columns])
                f.write(f"-- Primary Key\n")
                f.write(f"ALTER TABLE {table} ADD PRIMARY KEY ({pk_cols});\n\n")

            # Get foreign key constraints
            cursor.execute("""
                SELECT
                    kcu.column_name,
                    ccu.table_name as referenced_table,
                    ccu.column_name as referenced_column
                FROM
                    information_schema.table_constraints tc
                    JOIN information_schema.key_column_usage kcu
                        ON tc.constraint_name = kcu.constraint_name
                    JOIN information_schema.constraint_column_usage ccu
                        ON ccu.constraint_name = tc.constraint_name
                WHERE
                    tc.constraint_type = 'FOREIGN KEY'
                    AND tc.table_name = %s;
            """, (table,))

            fk_constraints = cursor.fetchall()

            if fk_constraints:
                f.write(f"-- Foreign Keys\n")
                for fk in fk_constraints:
                    col_name = fk[0]
                    ref_table = fk[1]
                    ref_col = fk[2]
                    f.write(f"ALTER TABLE {table} ADD FOREIGN KEY ({col_name}) ")
                    f.write(f"REFERENCES {ref_table}({ref_col});\n")
                f.write("\n")

    print("\nSchema extraction completed successfully!")
    print(f"Schema saved to {schema_file}")

except psycopg2.Error as e:
    print(f"Database error: {e}")
    sys.exit(1)
except Exception as e:
    print(f"Error: {e}")
    sys.exit(1)
finally:
    if 'conn' in locals():
        conn.close()
