import json

# File names
input_filename = 'reco.json'
output_filename = 'output.txt'

# Global starting number for the first column (continues increasing across all sections)
global_first_num = 167

# Define starting numbers for the second column for the specific groups
section_second_start = {
    "Identificar": 634,
    "Proteger": 696,
    "Detetar": 733,
    "Responder": 751,
    "Recuperar": 767
}

# Load JSON data from the input file using UTF-8 encoding
with open(input_filename, 'r', encoding='utf-8') as infile:
    data = json.load(infile)

# Open the output file in write mode with UTF-8 encoding
with open(output_filename, 'w', encoding='utf-8') as outfile:
    # Iterate over each section in the JSON data
    for section in data["sections"]:
        section_name = section.get("section", "")
        if section_name not in section_second_start:
            print(f"Warning: Section '{section_name}' not in mapping. Skipping...")
            continue

        # Get the starting second number for this section from the mapping
        second_num = section_second_start[section_name]
        
        # Process each recommendation in the section
        for recommendation in section["recommendations"]:
            # Retrieve and escape recommendation texts (to avoid breaking the tuple with single quotes)
            basic_text = recommendation.get("Inicial", "").replace("'", "''")
            intermediate_text = recommendation.get("Intermédio", "").replace("'", "''")
            advanced_text = recommendation.get("Avançado", "").replace("'", "''")
            
            # Create the tuple string in the desired format:
            # (global_first_num, second_num, 'basic text', 'intermediate text', 'advanced text'),
            tuple_str = f"({global_first_num},{second_num},'{basic_text}','{intermediate_text}','{advanced_text}'),\n"
            
            # Write the tuple to the output file
            outfile.write(tuple_str)
            
            # Increment the global first number and the section-specific second number
            global_first_num += 1
            second_num += 1

print(f"Output written to {output_filename}")
