---- File information ----
dblogo:
  Logo and images used for WGIA website construction.

html:
  WGIA web interface html code.

php:
  PHP scripts used for WGIA website construction.

exampleData:
	The example data used for each type of interaction analysis, including raw uploaded datasets, preprocessed datasets, and output results. Each folder is named: Analysis__model__ifWithCovariates.

processScripts:
  DataPreprocess:	
    Preprocessing code. The preprocessing code used for each type of interaction analysis. The batch preprocessing code for example files is in ./Rpreprocess/predata.bat.
  ReportGeneration:
	  Report generation code. The report generation code used for each type can be found in analysiscode_info.csv. The batch report generation code for example files is in ./Rreport/rmd.R.
  cuda_code.bat:
	  Code to generate example files for each type of interaction analysis using the localized software wgia.exe

wgia1.0:
	Localized executable software of WGIA.

analysiscode_info.csv:
	Information corresponding to each type of interaction analysis and method.
		Analysis: Abbreviation of the interaction analysis type.
		AnalysisType: Type of interaction analysis.
		methodType: The model used in interaction analysis.
		withCovariant: Whether covariates are allowed.
		preProcessScript: Name of the data preprocessing R script.
		analysisRmdScript: Name of the Rmd file for generating the result report.
		cmdCode: The command line code for the WGIA software to analyze this interaction type.
		example_savepath: Path to save all example files.
		html_example_input: Example input file for web interface upload.
		exe_example_input: The example input file of localized executable software that can be used directly after preprocessing.
		output_filename: Output file name after analyzing example input files with the localized executable software.
		output_distribution: Distribution file after analyzing example input files with the localized executable software.
		report: Report.html file generated from the output results.

