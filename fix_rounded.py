import os
import re

directory = 'resources/views'

regexes = [
    r'\brounded-md\b',
    r'\brounded-lg\b',
    r'\brounded-xl\b',
    r'\brounded-2xl\b',
    r'\brounded-3xl\b',
    r'\brounded-full\b',
    r'\brounded-\[[^\]]+\]' # No trailing \b because ] is not a word character
]
combined_regex = re.compile('|'.join(regexes))

for root, _, files in os.walk(directory):
    for file in files:
        if file.endswith('.blade.php'):
            filepath = os.path.join(root, file)
            with open(filepath, 'r') as f:
                content = f.read()
            
            new_content = combined_regex.sub('rounded-sm', content)
            
            # Let's restore the blurred background glows to rounded-full if they were changed
            new_content = new_content.replace('rounded-sm blur-[120px]', 'rounded-full blur-[120px]')
            new_content = new_content.replace('rounded-sm blur-[80px]', 'rounded-full blur-[80px]')
            new_content = new_content.replace('rounded-sm blur-[60px]', 'rounded-full blur-[60px]')
            new_content = new_content.replace('rounded-sm animate-aurora', 'rounded-full animate-aurora')
            
            if content != new_content:
                with open(filepath, 'w') as f:
                    f.write(new_content)
                print(f"Updated {filepath}")
