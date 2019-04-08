# Nand2Tetris Assembler PHP Implementation 

PHP implementation of the nand2tetris assembler project:
https://www.nand2tetris.org/project06

## Getting Started

### Prerequisites

You will need to have PHP installed before getting started:
https://www.php.net/manual/en/install.php

You'll also need to have a few Hack `asm` files ready to assemble

### Installing

Clone the repository anywhere in your system

```
cd [location]
git clone https://github.com/chickenn00dle/hack_assembler.git [new_name]
cd [new_name]
```

## Running the tests

If you don't have any `asm` files to test, grab some from the official nand2Tetris website:
https://www.nand2tetris.org/project06

### Break down into end to end tests

Using `Max.asm` provided by the nand2Tetris, make sure you are in the assembler directory and you have added `Add.asm` to this directory.

```
php assembler.php Max.asm
```

This will scan Max.asm and generate a new file called Max.hack

Verify this matches the provided compare file provided in project 6 here:
https://www.nand2tetris.org/software

## Authors

* **Rasmy Nguyen** - *Initial work* - [Chickenn00dle](https://github.com/chickenn00dle)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

The folks over at [nand2Tetris](www.nand2tetris.org) did an amazing job of putting together an approachable course that taught me a ton about how computers work under the hood. Thank you!
