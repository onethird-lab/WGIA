# Script:preProcess.R
# Description: This script process genomic data (matrix1.txt) to suit the cuda input, 
#              including handling missing values, 
#              and generating preprocessed output files for cuda calculation.
# Author: WGIA
# Date: 2024-06-19

# -----------------------------------------
# Section 1: Load arguments and set path
# -----------------------------------------
args=commandArgs(T)
# args=c('pwiikc5usr4ktv64f8rd', 'D:/software/webdeveloper/PHPCUSTOM/wwwroot')
# Sys.setenv(RSTUDIO_PANDOC = "D:/application/Pandoc")
rootpath = paste0(args[2], "/wgia/Public/job/") #'D:/software/webdeveloper/PHPCUSTOM/wwwroot/wgia/Public/job/'
setwd(paste0(rootpath, args[1]))

# -------------------------------
# Section 2: Load Libraries
# -------------------------------
library(data.table)
library(dplyr)

# -----------------------------------
# Section 3: Load files and remame
# -----------------------------------
# Function: get_extension
# Description: Get the source file extension
# Parameters:
#    -filename: The name of the file
# Returns: extension
# Example:
#    get_extension("aaa.t.txt")
get_extension <- function(filename) {
	match <- regexpr("\\.[^.]*$", filename)
	extension <- substring(filename, match)
	return(extension)
}
# Unzip the zip files -- matirx1
unzip(paste0(rootpath, args[1], '/matrix1.zip'), exdir = paste0(rootpath, args[1], "/matrix1_zipped/"))
file_list <- list.files(path = paste0(rootpath, args[1], "/matrix1_zipped/"), recursive = TRUE, full.names = TRUE)
if (length(file_list) > 0) {
    # Select the first file found and move it to the current directory 
    extension <- get_extension(file_list[1])
    file.rename(file_list[1], paste0(rootpath, args[1], "/matrix1",extension))
}

# --------------------------------------------
# Section 4: Replace missing valuse in the omics data with -999
# --------------------------------------------
# Function: process missing values in the source file
# Description: Reads a file, replaces missing values with missing_value, 
#              leave out the headerline and rownamesline, 
#              and writes the processed data to a new file with name added the prefix "pre_".
# Parameters:
#   - filepath: The path of the input file.
#   - output_name: The name of the output file.
#   - missing_value: the specified replacement value
# Returns: NULL
# Example:
#   process_file("matrix1.txt", "pre_matrix1.txt", missing_value)
process_file <- function(file_now, file_out, missing_value) {
  # Read the data
  data_now <- fread(file=paste0(rootpath, args[1], "/", file_now), data.table=FALSE, na.strings = c("", "NA", "NaN", "nan")) %>% as.data.frame()
  fwrite(data_now, file=paste0(rootpath, args[1], "/matrix1",".txt"), quote=FALSE, sep="\t", col.names=TRUE, row.names=FALSE)
  # Replace missing values with -999
  cat(paste0("   - the original file contains ", nrow(data_now), " markers and ", ncol(data_now)-1, " samples.\n"))
  cat(paste0("   - There are ", sum(is.na(data_now)), " missing values be replaced with -999!\n"))
  data_now[is.na(data_now)] <- missing_value
  cat(paste0("   - the processed file contains ", nrow(data_now), " markers and ", ncol(data_now)-1, " samples.\n"))
  # Write the processed data to a new file
  fwrite(data_now[,-1], file=file_out, quote=FALSE, sep="\t", col.names=FALSE)
}
# process the files
file_list <- list.files(path = paste0(rootpath, args[1], "/"), recursive = TRUE, full.names = FALSE)
missing_value <- -999
#  -- matirx1
for (file_now in file_list){
	if(file_now %in% c("matrix1.txt", "matrix1.tsv", "matrix1.csv")){
		cat(" - now is replacing the missing values in the data of omics1 ...\n")
		file_out <- paste0(rootpath, args[1], "/pre_matrix1",".txt")
		process_file(file_now, file_out, missing_value)
	}
}

cat(" - Data preprocessing finishied!\n")
