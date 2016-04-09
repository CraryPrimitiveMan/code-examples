#! /bin/bash

fstab_file=/etc/fstab
disk_path=/Volumes/
desktop_path=~/Desktop
disks_ntfs=$(diskutil list | grep Windows_NTFS | awk -F ':' '{print $2}' | sed 's/^[ ]*Windows_NTFS[ ]*//')
IFS=$(echo -en "\n\b")
fileNames=$(ls -v ${disk_path})
# clear fstab file
sudo sh -c "echo '' > ${fstab_file}"
for file in ${fileNames}; do
	if [[ -d "${disk_path}${file}" ]]; then
		for disk_ntfs in ${disks_ntfs}; do
			if [[ ${disk_ntfs} =~ ${file} ]]; then
				# add a ntfs disk
				file='LABEL='${file// /\\\\\\\\040}' none ntfs rw,auto,nobrowse'
				echo ${file}
				sudo sh -c "echo ${file} >> ${fstab_file}"
				sudo sh -c "echo '\n' >> ${fstab_file}"
			fi
		done
	fi
done
# create the disk link
if [[ ! -d "${desktop_path}${disk_path}" ]]; then
	ln -s ${disk_path} ${desktop_path}
fi
