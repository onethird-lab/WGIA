# Script:preProcess.R
# Description: This script process genomic data (matrix1.txt and matrix2.txt) from two different omics to suit the cuda input, 
#              including handling missing values, check the sample order, 
#              and generating preprocessed output files for cuda calculation.
# Author: WGIA
# Date: 2024-06-26

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
# # Unzip the zip files -- matirx1
# unzip(paste0(rootpath, args[1], '/matrix1.zip'), exdir = paste0(rootpath, args[1], "/matrix1_zipped/"))
# file_list <- list.files(path = paste0(rootpath, args[1], "/matrix1_zipped/"), recursive = TRUE, full.names = TRUE)
# if (length(file_list) > 0) {
#     # Select the first file found and move it to the current directory 
#     extension <- get_extension(file_list[1])
#     file.rename(file_list[1], paste0(rootpath, args[1], "/matrix1",extension))
# }

# ----------------------------------------------------------------------------------
# Section 4: Check if the sample order in matrix1.txt and matrix2.txt is the same
# ----------------------------------------------------------------------------------
cat("# -------------------------------------------------\n")
cat("# check sample order in omics1 file and omics2 file\n")
cat("# -------------------------------------------------\n")
# process the files
file_list <- list.files(path = paste0(rootpath, args[1], "/"), recursive = TRUE, full.names = FALSE)
for (file_now in file_list){
  if(file_now %in% c("matrix1.txt", "matrix1.tsv", "matrix1.csv")){
    matrix1 <- fread(file=paste0(rootpath, args[1], "/", file_now), data.table=FALSE, na.strings = c("", "NA", "NaN", "nan")) %>% as.data.frame()
  }
}
for (file_now in file_list){
  if(file_now %in% c("matrix2.txt", "matrix2.tsv", "matrix2.csv")){
    matrix2 <- fread(file=paste0(rootpath, args[1], "/", file_now), data.table=FALSE, na.strings = c("", "NA", "NaN", "nan")) %>% as.data.frame()
  }
}
colnames(matrix1)[1] <- "symbol"
colnames(matrix2)[1] <- "symbol"
# check if the colnames order is the same
ifOrderSame <- identical(colnames(matrix1), colnames(matrix2))
if(ifOrderSame){
  cat(" - The order of samples in omics1 file and omics2 file is the same.\n")
  cat(paste0(" - There are total of ", ncol(matrix1)-1, " samples.\n"))
  cat(" - They will be used for subsequent interaction analysis.\n")
}else{
  cat(" - The order of samples in omics1 file and omics2 file is different.\n")
  cat(paste0(" - There are ", ncol(matrix1)-1, " samples in omics1 file and ", ncol(matrix2)-1, " samples in omics2 file.\n"))
  cat(" - We will take the samples that are both exist in two groups and ensure they appear in the same order.\n")
  sample_common <- intersect(colnames(matrix1)[-1], colnames(matrix2)[-1])
  matrix1 <- matrix1 %>% dplyr::select(symbol, sample_common)
  matrix2 <- matrix2 %>% dplyr::select(symbol, sample_common)
  cat(" - The common samples were extracted. The order of them was also matched.\n")
  cat(paste0(" - A total of ", ncol(matrix1)-1, " samples were left. They will be used for subsequent interaction analysis."))
}
# write to file the data with same sample order
fwrite(matrix1, file=paste0(rootpath, args[1], "/matrix1",".txt"), quote=FALSE, sep="\t", col.names=TRUE, row.names=FALSE)
fwrite(matrix2, file=paste0(rootpath, args[1], "/matrix2",".txt"), quote=FALSE, sep="\t", col.names=TRUE, row.names=FALSE)


# ------------------------------------------------------------------
# Section 5: Replace missing valuse in the omics data with -999
# ------------------------------------------------------------------
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
  # Replace missing values with -999
  cat(paste0("   - the original file contains ", nrow(data_now), " markers and ", ncol(data_now)-1, " samples.\n"))
  cat(paste0("   - There are ", sum(is.na(data_now)), " missing values be replaced with -999!\n"))
  data_now[is.na(data_now)] <- missing_value
  cat(paste0("   - the processed file contains ", nrow(data_now), " markers and ", ncol(data_now)-1, " samples.\n"))
  # Write the processed data to a new file
  fwrite(data_now[,-1], file=file_out, quote=FALSE, sep="\t", col.names=FALSE)
}
# process the files
missing_value <- -999
#  -- matirx1
file_now <- "matrix1.txt"
cat(" - now is replacing the missing values in the data of omics1 ...\n")
file_out <- paste0(rootpath, args[1], "/pre_matrix1",".txt")
process_file(file_now, file_out, missing_value)
#  -- matirx2
file_now <- "matrix2.txt"
cat(" - now is replacing the missing values in the data of omics2 ...\n")
file_out <- paste0(rootpath, args[1], "/pre_matrix2",".txt")
process_file(file_now, file_out, missing_value)


cat(" - Data preprocessing finishied!\n")

