# Script:preProcess.R
# Description: This script process genomic data from two different groups (matrix1_0.txt and matrix1_1.txt) to suit the cuda input, 
#              including handling missing values, check if the order of the markers in two groups is the same, 
#              and generating preprocessed output files for cuda calculation.
# Author: WGIA
# Date: 2024-06-24

# -----------------------------------------
# Section 1: Load arguments and set path
# -----------------------------------------
args=commandArgs(T)
# args=c('dq1a6r74f6kiyu33z4mm', 'D:/software/webdeveloper/PHPCUSTOM/wwwroot')
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
# # Unzip the zip files -- matirx1_0
# unzip(paste0(rootpath, args[1], '/matirx1_0.zip'), exdir = paste0(rootpath, args[1], "/matrix1_0_zipped/"))
# file_list <- list.files(path = paste0(rootpath, args[1], "/matrix1_0_zipped/"), recursive = TRUE, full.names = TRUE)
# if (length(file_list) > 0) {
#   # Select the first file found and move it to the current directory 
#   extension <- get_extension(file_list[1])
#   file.rename(file_list[1], paste0(rootpath, args[1], "/matirx1_0",extension))
# }
# # Unzip the zip files -- matirx1_1
# unzip(paste0(rootpath, args[1], '/matirx1_1.zip'), exdir = paste0(rootpath, args[1], "/matrix1_1_zipped/"))
# file_list <- list.files(path = paste0(rootpath, args[1], "/matrix1_1_zipped/"), recursive = TRUE, full.names = TRUE)
# if (length(file_list) > 0) {
#   # Select the first file found and move it to the current directory 
#   extension <- get_extension(file_list[1])
#   file.rename(file_list[1], paste0(rootpath, args[1], "/matirx1_1",extension))
# }

# ------------------------------------------------------------------
# Section 4: check marker order in matrix1_0.txt and matrix1_1.txt
# ------------------------------------------------------------------
cat("# -------------------------------------------------\n")
cat("# check marker order in group1 and group2\n")
cat("# -------------------------------------------------\n")
# process the files
file_list <- list.files(path = paste0(rootpath, args[1], "/"), recursive = TRUE, full.names = FALSE)
for (file_now in file_list){
  if(file_now %in% c("matrix1_0.txt", "matrix1_0.tsv", "matrix1_0.csv")){
    matrix1_0 <- fread(file=paste0(rootpath, args[1], "/", file_now), data.table=FALSE, na.strings = c("", "NA", "NaN", "nan")) %>% as.data.frame()
  }
}
for (file_now in file_list){
  if(file_now %in% c("matrix1_1.txt", "matrix1_1.tsv", "matrix1_1.csv")){
    matrix1_1 <- fread(file=paste0(rootpath, args[1], "/", file_now), data.table=FALSE, na.strings = c("", "NA", "NaN", "nan")) %>% as.data.frame()
  }
}
colnames(matrix1_0)[1] <- "symbol"
colnames(matrix1_1)[1] <- "symbol"
# check if the rowname order is the same
ifOrderSame <- identical(matrix1_0$symbol, matrix1_1$symbol)
if(ifOrderSame){
  cat(" - The order of markers in group1 and group2 is the same.\n")
  cat(paste0(" - There are total of ", nrow(matrix1_0), " markers.\n"))
  cat(" - They will be used for subsequent interaction analysis.\n")
}else{
  cat(" - The order of markers in group1 and group2 is different.\n")
  cat(paste0(" - There are ", nrow(matrix1_0), " markers in group1 and ", nrow(matrix1_1), " markers in group2.\n"))
  cat(" - We will take the markers that are both exist in two groups and ensure they appear in the same order.\n")
  symbol_common <- intersect(matrix1_0$symbol, matrix1_1$symbol)
  matrix1_0 <- data.frame(symbol=symbol_common) %>% left_join(matrix1_0, by="symbol")
  matrix1_1 <- data.frame(symbol=symbol_common) %>% left_join(matrix1_1, by="symbol")
  cat(" - The common markers were extracted. The order of them was also matched.\n")
  cat(paste0(" - A total of ", nrow(matrix1_0), " markers were left. They will be used for subsequent interaction analysis."))
}
# write to file the data with same symbol order
fwrite(matrix1_0, file=paste0(rootpath, args[1], "/matrix1_0",".txt"), quote=FALSE, sep="\t", col.names=TRUE, row.names=FALSE)
fwrite(matrix1_1, file=paste0(rootpath, args[1], "/matrix1_1",".txt"), quote=FALSE, sep="\t", col.names=TRUE, row.names=FALSE)


# ---------------------------------------------------------------
# Section 5: Replace missing valuse in the omics data with -999
# ---------------------------------------------------------------
cat("# ------------------------------------------------\n")
cat("# Process missing valuse in the omics data\n")
cat("# ------------------------------------------------\n")
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
#  -- matirx1_0
file_now <- "matrix1_0.txt"
cat(" - now is replacing the missing values in the data of group1 ...\n")
file_out <- paste0(rootpath, args[1], "/pre_matrix1_0",".txt")
process_file(file_now, file_out, missing_value)
#  -- matirx1_1
file_now <- "matrix1_1.txt"
cat(" - now is replacing the missing values in the data of group2 ...\n")
file_out <- paste0(rootpath, args[1], "/pre_matrix1_1",".txt")
process_file(file_now, file_out, missing_value)


cat(" - Data preprocessing finishied!\n")
