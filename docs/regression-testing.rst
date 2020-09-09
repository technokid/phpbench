.. _comparison:

Regression Testing
==================

Sometimes you need to ensure that modifications to existing code do not cause
performance regressions.

PHPBench allows you to store results and use them as a baseline for subsequent
runs.

.. _baseline:

Creating a baseline
-------------------

The baseline is a tagged benchmark result. When creating a baseline we should
try and ensure it is as accurate as possible, it is therefore recommended to
use find a low value of :ref:`retry_threshold` and use a appropriate amount of
iterations (e.g. 10):

Run your benchmark on the code to which you want to compare:

.. code-block:: bash

    phpbench run tests/Benchmark/MyBenchmark.php --tag=original --retry-threshold=5 --iterations=10

Compare against the baseline
----------------------------

Switch to the new version of your code and run PHPBench again:

.. code-block:: bash

    phpbench run tests/Benchmark/MyBenchmark.php --report=aggregate --uuid=tag:original --retry-threshold=5 --iterations=10


Note that:

- ``--uuid`` is used to reference the previous, tagged, run, which will merge
  the previous benchmarks into the results.  - ``--report=aggregate`` shows
  the aggregate report, and if a baseline is present it will show differences.

The final report should look something like:

.. image:: images/baseline.png

The ``mean``, ``mode`` and ``rstdev`` columns show the percentage difference
from the previous run.

Assertions
----------

You can compare against baselines in assertions, e.g.

.. code-block:: bash

    phpbench run tests/Benchmark/MyBenchmark.php --uuid=tag:original --retry-threshold=5 --iterations=10 --assert="variant.mode <= baseline.mode +/- 5%"

We assert the the current run's ``mode`` is less than or equal to the baseline
``mode`` and tolerate a variance within 5% of the baseline ``mode``.

See :doc:`assertions` for more information.
