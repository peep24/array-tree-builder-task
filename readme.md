# PHP Array Tree Building

In reference to [this stack overflow](https://stackoverflow.com/questions/73958367/php-flat-associative-array-into-deeply-nested-array-by-parent-property/) question.

### Data Checking

This is my chain of thoughts in checking the data in play, writing as I go.
This is based on the output that already existed in this repo, I have not regenerated it. 

Taking a random item, checking input to get expectations, then checking that against outputs:

- Check of `1899 - The Incredible Hulk"`.
- Should have parent chain: 
  - 3 - Singh Is Kinng
  - 19 - Rize
  - 987 - Killing Zelda Sparks
  - 1917 - Elysium
  - 1569 - Rockstar
  - 1899 - The Incredible Hulk
- Should have children:
  - 1906 - Kurbaan
  - 1903 - Jayantabhai Ki Luv Story
- Newfunc output:
  - Has the required children.
  - ERROR: Chain fails due to duplicate IDs within input for id `1569`. Three items have this id:
    - Rockstar
    - Black
    - Ata Pata Laapata

Alright, so from the above check it looks like our input has duplicates which may be causing unexpected issues. Let's write some code to check how widespread this is.

Created script `check_duplicate_ids.php`:

```bash
> php check_duplicate_ids.php
Found 3 duplicates 547 times
Found 2 duplicates 1139 times
```

So, out of the 7216 input items, there may be > 2k dupe ids.
I'd imagine this is causing issues for both function types.

Also done a quick check of the above data spot-check of `1899` in the oldfunc output, but that ID does not seem to exist at all.

As another very quick cursory test, if all is working well with correct input we can assume that the output should have the same frequency of the string `"id":` since all items should exist and only exist once. Using my text editor find functionality to get counts:

- input_large.json: 7216
- output_large_newfunc.json: 4903
- output_large_oldfunc.json: 12505

The lesser count for `newfunc` is expected, since the functions will essentially de-duplicate ids as part of its first loop. What should we expect for `newfunc` taking this into account?:

```txt
7216 - (1139 + (547 * 2)) = 4983
total - (2-count-dupes + (3-count-dupes * 2))
3 count dupes are counted twice only 1/3 of each ID are real, 2/3 are dupes.
```

So we're 80 off, which could indicate an issue with the function, or other issues with the input data.

The old func, with 12505 results, is inflating that input number. Might be a side affect of the dupes and its logic, have not traced it through, but from a quick look I see the function uses name in its logic, which is normally risky depending on context, but there are also duplicates for name in this dataset upon ID.

Lets see why the `newfunc` count might be 80 out.  My guess would be items without parents.  Created script `check_no_parents.php`:

```txt
27 items have no existing parent:
```

So that's 26 extra items accounted for. Looking further, some of those then have their own children which would not be in the output, but it gets complex to count/track, but this likely makes up some numbers.